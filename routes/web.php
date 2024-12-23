<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::group(['namespace' => 'Core'], function () {
        Route::group(['namespace' => 'Auth'], function () {
            Route::group(['controller' => LoginController::class], function () {
                Route::get('/login', 'index')->name('login');
                Route::post('/login', 'auth');
                Route::post('/logout', 'logout')->name('logout');
            });

            Route::group(['prefix' => 'retrieve-password', 'controller' => RetrievePasswordController::class], function () {
                Route::get('/', 'index')->name('retrieve-password');
                Route::post('/', 'sendMail');
            });

            Route::group(['prefix' => 'first-login', 'controller' => FirstLoginController::class], function () {
                Route::get('/', 'index')->name('first-login');
                Route::post('/', 'sendMail');
            });
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::group(['controller' => DashboardController::class], function () {
                Route::get('/home', 'home')->name('home');
                Route::get('/', 'index')->name('index');
            });

            Route::group([], function () {
                Route::group([], function () {
                    Route::group(['as' => 'core_users.', 'prefix' => 'core_users', 'controller' => CoreUserController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/ajax', 'ajax')->name('ajax');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{coreUser}', 'show')->name('show');
                        Route::get('/{coreUser}/edit', 'edit')->name('edit');
                        Route::patch('/{coreUser}', 'update')->name('update');
                        Route::patch('/{coreUser}/lock', 'lock')->name('lock');
                        Route::delete('/{coreUser}', 'destroy')->name('destroy');
                    });

                    Route::group(['as' => 'core_groups.', 'prefix' => 'core_groups', 'controller' => CoreGroupController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{coreGroup}/edit', 'edit')->name('edit');
                        Route::patch('/{coreGroup}', 'update')->name('update');
                        Route::delete('/{coreGroup}', 'destroy')->name('destroy');
                    });
                    Route::group(['as' => 'core_doctors.', 'prefix' => 'core_doctors', 'controller' => CoreDoctorController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::get('/{coreDoctor}/edit', 'edit')->name('edit');
                        Route::patch('/{coreDoctor}', 'update')->name('update');
                        Route::post('/', 'store')->name('store');
                        Route::delete('/{coreDoctor}', 'destroy')->name('destroy');
                    });
                    Route::group(['as' => 'doctor_specialization.', 'prefix' => 'doctor_specialization', 'controller' => DoctorSpecializationController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::get('/{doctorSpecialization}/edit', 'edit')->name('edit');
                        Route::patch('/{doctorSpecialization}', 'update')->name('update');
                        Route::post('/', 'store')->name('store');
                        Route::delete('/{doctorSpecialization}', 'destroy')->name('destroy');
                    });
                    Route::group(['as' => 'core_reservation_slots.', 'prefix' => 'core_reservation_slots', 'controller' => ReservationSlotController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::get('/{reservationSlot}/edit', 'edit')->name('edit');
                        Route::patch('/{reservationSlot}', 'update')->name('update');
                        Route::post('/', 'store')->name('store');
                        Route::delete('/{reservationSlot}', 'destroy')->name('destroy');
                    });
                    Route::group(['as' => 'core_specialization.', 'prefix' => 'core_specialization', 'controller' => SpecializationController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/create', 'create')->name('create');
                        Route::get('/{coreSpecializations}/edit', 'edit')->name('edit');
                        Route::patch('/{coreSpecializations}', 'update')->name('update');
                        Route::post('/', 'store')->name('store');
                        Route::delete('/{coreSpecializations}', 'destroy')->name('destroy');
                    });
                });

                Route::group([], function () {
                    Route::group(['as' => 'core_menus.', 'prefix' => 'core_menus', 'controller' => CoreMenuController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/ajax', 'ajax')->name('ajax');
                        Route::post('/', 'updateAll')->name('updateAll');
                    });

                    Route::group(['as' => 'core_permissions_general.', 'prefix' => 'core_permissions_general', 'controller' => CorePermissionController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::any('/add', 'create')->name('create');
                        Route::any('/update', 'update')->name('update');
                    });

                    Route::group(['as' => 'core_permissions_exceptions.', 'prefix' => 'core_permissions_exceptions', 'controller' => CorePermissionExceptionController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/users/{coreUser}/exceptions', 'editUserPermissionsExceptions')->name('editUserPermissionsExceptions');
                        Route::patch('/{coreUser}', 'update')->name('update');
                        Route::delete('/{permission}', 'destroy')->name('destroy');
                    });
                });

                Route::group(['namespace' => 'Addresses'], function () {
                    Route::group(['as' => 'core_countries.', 'prefix' => 'core_countries', 'controller' => CoreCountryController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/ajax', 'ajax')->name('ajax');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{coreCountry}/edit', 'edit')->name('edit');
                        Route::patch('/{coreCountry}', 'update')->name('update');
                        Route::delete('/{coreCountry}', 'destroy')->name('destroy');
                    });

                    Route::group(['as' => 'core_provinces.', 'prefix' => 'core_provinces', 'controller' => CoreProvinceController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/ajax', 'ajax')->name('ajax');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{coreProvince}/edit', 'edit')->name('edit');
                        Route::patch('/{coreProvince}', 'update')->name('update');
                        Route::delete('/{coreProvince}', 'destroy')->name('destroy');
                    });

                    Route::group(['as' => 'core_cities.', 'prefix' => 'core_cities', 'controller' => CoreCityController::class], function () {
                        Route::get('/', 'index')->name('index');
                        Route::get('/ajax', 'ajax')->name('ajax');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{coreCity}/edit', 'edit')->name('edit');
                        Route::patch('/{coreCity}', 'update')->name('update');
                        Route::delete('/{coreCity}', 'destroy')->name('destroy');
                    });
                });

                Route::group(['as' => 'core_admin_options.', 'prefix' => 'core_admin_options', 'controller' => CoreAdminOptionController::class], function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{coreAdminOption}/edit', 'edit')->name('edit');
                    Route::patch('/{coreAdminOption}', 'update')->name('update');
                    Route::delete('/{coreAdminOption}', 'destroy')->name('destroy');
                });
            });

            Route::group(['as' => 'core_customers.', 'prefix' => 'core_customers', 'controller' => CoreCustomerController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/ajax', 'ajax')->name('ajax');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{coreCustomer}', 'show')->name('show');
                Route::get('/{coreCustomer}/edit', 'edit')->name('edit');
                Route::patch('/{coreCustomer}', 'update')->name('update');
                Route::patch('/{coreCustomer}/lock', 'lock')->name('lock');
                Route::delete('/{coreCustomer}', 'destroy')->name('destroy');
                Route::get('/{coreCustomer}/vcard', 'getVCard')->name('getVCard');
            });
            Route::group(['middleware' => 'auth'], function () {
                Route::group(['as' => 'core_reservations.', 'prefix' => 'core_reservations', 'controller' => ReservationController::class], function () {
                    Route::get('/doctors', 'getDoctorsBySpecialization')->name('doctors');
                    Route::get('/core_reservations/slots', 'getAvailableSlots')->name('slots');
                    Route::get('/', 'index')->name('index');
                    Route::get('/ajax', 'ajax')->name('ajax');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('/{coreReservation}', 'show')->name('show');
                    // Middleware pentru verificarea dreptului de proprietate
                    Route::group(['middleware' => 'checkReservationOwnership'], function () {
                        Route::get('/{coreReservation}/edit', 'edit')->name('edit');
                        Route::patch('/{coreReservation}', 'update')->name('update');
                        Route::patch('/{coreReservation}/lock', 'lock')->name('lock');
                        Route::delete('/{coreReservation}', 'destroy')->name('destroy');
                    });
                });
            });
            Route::group(['as' => 'manager_reservation.', 'prefix' => 'manager_reservation', 'controller' => ManagerReservationController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/ajax', 'ajax')->name('ajax');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{coreReservation}', 'show')->name('show');
                Route::get('/{coreReservation}/edit', 'edit')->name('edit');
                Route::patch('/{coreReservation}', 'update')->name('update');
                Route::patch('/{coreReservation}/lock', 'lock')->name('lock');
                Route::delete('/{coreReservation}', 'destroy')->name('destroy');
                Route::get('/doctors', 'getDoctorsBySpecialization')->name('doctors');
                Route::get('/manager_reservation/{id}/edit', 'edit')->name('edit');
            });
        });

        Route::group(['as' => 'filters.', 'prefix' => 'filters', 'namespace' => 'Filters'], function () {
            Route::group(['controller' => CoreCityServiceController::class], function () {
                Route::get('/core_cities/ajaxFilter', 'ajaxFilter')->name('core_cities.ajaxFilter');
            });
            Route::group(['controller' => CoreCustomerController::class], function () {
                Route::get('/customers/fields', 'fieldFilter')->name('core_customers.fieldFilter');
            });
        });
    });
});


Route::group(['errors', 'namespace' => 'App\Http\Controllers\Core', 'controller' => RouteErrorController::class], function () {
    Route::get('/no_permission', 'noPermission')->name('no_permission');
    Route::fallback('fallback')->name('fallback');
});
