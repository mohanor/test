<?php

namespace BookneticApp\Backend\Appointments;

use BookneticApp\Backend\Appointments\Helpers\AppointmentService;
use BookneticApp\Models\Appointment;
use BookneticApp\Models\AppointmentExtra;
use BookneticApp\Models\AppointmentPrice;
use BookneticApp\Models\Customer;
use BookneticApp\Models\Location;
use BookneticApp\Models\Service;
use BookneticApp\Models\ServiceExtra;
use BookneticApp\Models\Staff;
use BookneticApp\Providers\Core\Capabilities;
use BookneticApp\Providers\Core\Permission;
use BookneticApp\Providers\Helpers\Date;
use BookneticApp\Providers\Helpers\Helper;
use BookneticApp\Providers\UI\DataTableUI;

class Controller extends \BookneticApp\Providers\Core\Controller
{
    private DataTableUI $dataTable;

    private array $appointmentStatuses;

    public static function _delete( $deleteIDs )
    {
        Capabilities::must( 'appointments_delete' );

        AppointmentService::deleteAppointment( $deleteIDs );

        return false;
    }

    public function index()
    {
        Capabilities::must( 'appointments' );

        $this->appointmentStatuses = Helper::getAppointmentStatuses();

        $totalPrice = sprintf( "SUM(%s * %s) AS total_price",
            AppointmentPrice::getField( 'price' ),
            AppointmentPrice::getField( 'negative_or_positive' )
        );

        $appointments = Appointment::leftJoin( 'customer', [ 'first_name', 'last_name', 'email', 'profile_image', 'phone_number' ] )
            ->leftJoin( 'staff', [ 'name', 'profile_image' ] )
            ->leftJoin( 'location', [ 'name' ] )
            ->leftJoin( 'service', [ 'name' ] )
            ->leftJoin( 'prices', [] )
            ->groupBy( Appointment::getField( 'id' ) )
            ->select( [ Appointment::getField( '*' ), $totalPrice ] );

        $dataTable = new DataTableUI( $appointments );
        $this->dataTable = $dataTable;

        $dataTable->setIdFieldForQuery( Appointment::getField( 'id' ) );
        $dataTable->setModule( 'appointments' );
        $dataTable->setTitle( bkntc__( 'Appointments' ) );

        $this->setFilters();
        $this->setActions();
        $this->setButtons();

        $dataTable->searchBy( [
            Appointment::getField( 'id' ),
            Location::getField( 'name' ),
            Service::getField( 'name' ),
            Staff::getField( 'name' ),
            'CONCAT(' . Customer::getField( 'first_name' ) . ", ' ', " . Customer::getField( 'last_name' ) . ')',
            Customer::getField( 'email' ),
            Customer::getField( 'phone_number' ),
        ] );

        $this->setColumns();

        $dataTable->setRowsPerPage( 12 );

        $table = $dataTable->renderHTML();

        $this->view( 'index', [ 'table' => $table ] );
    }

    private function setFilters()
    {
        $this->dataTable->addFilter( Appointment::getField( 'date' ), 'date', bkntc__( 'Date' ), fn( $val, $query ) => $query
            ->where( 'starts_at', '<=', Date::epoch( $val, '+1 day' ) )
            ->where( 'ends_at', '>=', Date::epoch( $val ) )
        );
        $this->dataTable->addFilter( Service::getField( 'id' ), 'select', bkntc__( 'Service' ), '=', [ 'model' => new Service() ] );
        $this->dataTable->addFilter( Customer::getField( 'id' ), 'select', bkntc__( 'Customer' ), '=', [
            'model' => Customer::my(),
            'name_field' => 'CONCAT(`first_name`, \' \', last_name)'
        ] );

        $this->dataTable->addFilter( Staff::getField( 'id' ), 'select', bkntc__( 'Staff' ), '=', [ 'model' => new Staff() ] );

        $statusFilter = [];
        foreach ( $this->appointmentStatuses as $k => $v ) {
            $statusFilter[ $k ] = $v[ 'title' ];
        }
        $this->dataTable->addFilter( Appointment::getField( 'status' ), 'select', bkntc__( 'Status' ), '=', [
            'list' => $statusFilter
        ], 1 );

        $this->dataTable->addFilter( null, 'select', bkntc__( 'Filter' ), function ( $val, $query ) {
            switch ( $val ) {
                case 0:
                    return $query->where( Appointment::getField( 'ends_at' ), '<', Date::epoch() );
                case 1:
                    return $query->where( Appointment::getField( 'starts_at' ), '>', Date::epoch() );
                default:
                    return $query;
            }
        }, [
            'list' => [ 0 => bkntc__( 'Finished' ), 1 => bkntc__( 'Upcoming' ) ]
        ], 1 );
    }

    private function setActions()
    {
        $this->dataTable->addAction( 'info', bkntc__( 'Info' ) );
        $this->dataTable->addAction( 'edit', bkntc__( 'Edit' ) );
        $this->dataTable->addAction( 'delete', bkntc__( 'Delete' ), [ static::class, '_delete' ], DataTableUI::ACTION_FLAG_SINGLE | DataTableUI::ACTION_FLAG_BULK );
    }

    private function setButtons()
    {
        $this->dataTable->activateExportBtn();

        if ( Capabilities::userCan( 'appointments_add' ) ) {
            $this->dataTable->addNewBtn( bkntc__( 'NEW APPOINTMENT' ) );
        }
    }

    private function setColumns()
    {
        $this->dataTable->addColumns( bkntc__( 'ID' ), 'id' );

        $this->dataTable->addColumns( bkntc__( 'START DATE' ), function ( $row ) {
            if ( $row[ 'ends_at' ] - $row[ 'starts_at' ] >= 24 * 60 * 60 ) {
                return Date::datee( $row[ 'starts_at' ] );
            } else {
                return Date::dateTime( $row[ 'starts_at' ] );
            }
        }, [ 'order_by_field' => 'starts_at' ] );

        $this->dataTable->addColumns( bkntc__( 'CUSTOMER' ), function ( $row ) {
            if ( array_key_exists( $row[ 'status' ], $this->appointmentStatuses ) ) {
                $status = $this->appointmentStatuses[ $row[ 'status' ] ];
                $badge = '<div class="appointment-status-icon ml-3" style="background-color: ' . htmlspecialchars( $status[ 'color' ] ) . '2b">
                                    <i style="color: ' . htmlspecialchars( $status[ 'color' ] ) . '" class="' . htmlspecialchars( $status[ 'icon' ] ) . '"></i>
                                </div>';
            } else {
                $badge = '<span class="badge badge-dark">' . $row[ 'status' ] . '</span>';
            }

            $customerHtml = Helper::profileCard( $row[ 'customer_first_name' ] . ' ' . $row[ 'customer_last_name' ], $row[ 'customer_profile_image' ], $row[ 'customer_email' ], 'Customers' ) . $badge;

            return '<div class="d-flex align-items-center justify-content-between">' . $customerHtml . '</div>';
        }, [ 'is_html' => true, 'order_by_field' => 'customer_first_name' ], true );

        $this->dataTable->addColumnsForExport( bkntc__( 'Customer' ), fn( $appointment ) => $appointment[ 'customer_first_name' ] . ' ' . $appointment[ 'customer_last_name' ] );

        $extraFields = [
            'DISTINCT ' . AppointmentExtra::getField( 'extra_id' ),
            AppointmentExtra::getField( 'appointment_id' ),
            AppointmentExtra::getField( 'quantity' ),
            AppointmentExtra::getField( 'price' ),
            AppointmentExtra::getField( 'duration' ),
        ];

        $allExtras = AppointmentExtra::select( $extraFields )->leftJoin( ServiceExtra::class, [
            'id',
            'name'
        ], ServiceExtra::getField( 'id' ), AppointmentExtra::getField( 'extra_id' ), true );

        if ( Helper::isSaaSVersion() ) {
            $allExtras = $allExtras->where( ServiceExtra::getField( 'tenant_id' ), Permission::tenantId() );
        }

        foreach ( $allExtras->fetchAll() as $extra ) {
            $this->dataTable->addColumnsForExport( $extra[ 'service_extras_name' ], function ( $appointment ) use ( $extra ) {
                if ( $appointment[ 'id' ] == $extra[ 'appointment_id' ] ) {
                    return sprintf( 'Quantity: %s | Price: %s | Duration: %s',
                        $extra[ 'quantity' ],
                        $extra[ 'price' ],
                        $extra[ 'duration' ]
                    );
                }

                return '-';
            } );
        }

        $this->dataTable->addColumnsForExport( bkntc__( 'Customer Email' ), 'customer_email' );
        $this->dataTable->addColumnsForExport( bkntc__( 'Customer Phone Number' ), 'customer_phone_number' );

        $this->dataTable->addColumns( bkntc__( 'STAFF' ), fn( $appointment ) => Helper::profileCard( $appointment[ 'staff_name' ], $appointment[ 'staff_profile_image' ], '', 'staff' ), [ 'is_html' => true, 'order_by_field' => 'staff_name' ] );

        $this->dataTable->addColumns( bkntc__( 'SERVICE' ), 'service_name' );
        $this->dataTable->addColumns( bkntc__( 'PAYMENT' ), function ( $row ) {
            $badge = ' <img class="invoice-icon" data-load-modal="payments.info" data-parameter-id="' . (int) $row[ 'id' ] . '" src="' . Helper::icon( 'invoice.svg' ) . '"> ';
            return Helper::price( $row[ 'total_price' ] ) . $badge;
        }, [ 'is_html' => true ] );

        $this->dataTable->addColumns( bkntc__( 'DURATION' ), fn( $row ) => Helper::secFormat( ( (int) $row[ 'ends_at' ] - (int) $row[ 'starts_at' ] ) ), [ 'is_html' => true, 'order_by_field' => '( ends_at - starts_at )' ] );

        $this->dataTable->addColumns( bkntc__( 'CREATED AT' ), fn( $row ) => Date::dateTime( $row[ 'created_at' ] ) );
    }
}
