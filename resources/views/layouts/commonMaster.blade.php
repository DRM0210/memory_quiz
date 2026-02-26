<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}"
    data-base-url="{{ url('/') }}" data-framework="laravel" data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Emt App Dashboard</title>
    <meta name="description" content="#" />
    <meta name="keywords" content="#">
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Canonical SEO -->
    <link rel="canonical" href="#">
    <!-- Favicon (Company Icon) -->
    <link rel="icon" type="image/x-icon" href="{{ isset($company) && $company && $company->icon ? asset($company->icon) : asset('assets/img/favicon/icon.png') }}" />



    <!-- Include Styles -->
    @include('layouts/sections/styles')

    <!-- Include Scripts for customizer, helper, analytics, config -->
    @include('layouts/sections/scriptsIncludes')

    <style>
        /* Sidebar panel logo: fit within brand area, keep aspect ratio */
        #layout-menu .app-brand-logo img.sidebar-brand-logo,
        .layout-menu.menu-vertical .app-brand-logo img.sidebar-brand-logo {
            display: block;
            max-height: 40px;
            width: auto;
            max-width: 180px;
            object-fit: contain;
            object-position: left center;
            vertical-align: middle;
        }
        /* Collapsed sidebar: centered logo */
        .menu-vertical.menu-collapsed .app-brand-logo img.sidebar-brand-logo {
            max-height: 32px;
            max-width: 32px;
            margin: 0 auto;
        }
        /* Sidebar company name font size */
        #layout-menu .app-brand-text.demo,
        .layout-menu.menu-vertical .app-brand-text.demo {
            font-size: 15px;
        }
    </style>
</head>

<body>


    <!-- Layout Content -->
    @yield('layoutContent')
    <!--/ Layout Content -->



    <!-- Include Scripts -->
    @include('layouts/sections/scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {

            // code for Plant machine get
            @if(Route::has('client-machine-details'))
            $('#product_code').change(function() {
                var mid = $(this).val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-machine-details') }}",
                    data: {
                        mid: mid,
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            var DataMachine = data.machine;
                            $('#product_make').val(DataMachine.machine_make);
                            $('#product_model').val(DataMachine
                                .machine_model); // Corrected line
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
            @endif

            // code for Plant machine get
            @if(Route::has('client-machine'))
            $('#product_type').change(function() {
                $('#product_code').html('');
                tid = $(this).val();
                var cid = $(this).attr('data-id');
                var pid = $(this).attr('plant-id');
                _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-machine') }}",
                    data: {
                        tid: tid,
                        pid: pid,
                        cid: cid,
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            //console.log(data);
                            var option =
                                '<option value="" disabled selected >Select Product</option>';
                            data.forEach(function(optionData) {
                                option += '<option value="' + optionData.id + '">' +
                                    optionData.name + '</option>';
                            });
                            $('#product_code').html(option);
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
            @endif

            // code for Plant Department get
            @if(Route::has('client-department-contact'))
            $('#plant_id1').change(function() {
                $('#dept').html('');
                var pid = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-department-contact') }}",
                    data: {
                        pid: pid,
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            var DataDepartment = data.plant;
                            $("#product_type").attr('plant-id', DataDepartment.id);
                            $("#contact_person").val(DataDepartment.contact_person);
                            $("#product_type").attr('data-id', DataDepartment.client_id);
                            $("#email").val(DataDepartment.email);
                            $("#phone").val(DataDepartment.phone);
                            $("#mobile").val(DataDepartment.mobile);
                            $("#department").val(DataDepartment.contact_person);
                            $("#designation").val(DataDepartment.designation);
                            $("#address").val(DataDepartment.address);
                            var DataPlant = data.department;
                            var option2 =
                                '<option value="" disabled selected >Select department</option>'; // Changed 'Select department' to 'Select department'
                            DataPlant.forEach(function(optionData) {
                                option2 += '<option value="' + optionData.id + '">' +
                                    optionData.name + '</option>';
                            });
                            $('#dept').html(option2); // Removed extra space after '#dept'
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
            @endif

            // get client group
            @if(Route::has('client-group-get'))
            $("#client_id").change(function() {
                $('#client_group').html('');
                $('#plant_id').html('');
                cid = $(this).val();
                _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-group-get') }}",
                    data: {
                        cid: cid,
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            var DataGroup = data.group;
                            var DataPlant = data.plant;
                            var option1 = '';
                            var option2 =
                                '<option value="" disabled selected >Select plant</option>';
                            DataGroup.forEach(function(optionData) {
                                option1 += '<option value="' + optionData.id + '">' +
                                    optionData.name + '</option>';
                            });
                            DataPlant.forEach(function(optionData) {
                                option2 += '<option value="' + optionData.id + '">' +
                                    optionData.name + '</option>';
                            });
                            $('#client_group').html(option1);
                            $('#plant_id1 ').html(option2);
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });
            @endif

            // code for Machine view modal
            $(".closeM").click(function() {
                mid = $(this).attr('data-id');
                $("#exampleModal" + mid).modal('hide');
            });

            $(".machinView").click(function() {
                mid = $(this).attr('data-id');
                $("#exampleModal" + mid).modal('show');
            });

            // code for Plant Department get
            @if(Route::has('client-department'))
            $('#plant_id').change(function() {
                $('#dept').html('');
                pid = $(this).val();
                _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('client-department') }}",
                    data: {
                        pid: pid,
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            //console.log(data);
                            var option =
                                '<option value="" disabled selected >Select Department</option>';
                            data.forEach(function(optionData) {
                                option += '<option value="' + optionData.id + '">' +
                                    optionData.name + '</option>';
                            });
                            $('#dept').html(option);
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
            @endif
        });

        // code for city get get
        @if(Route::has('state.get.city'))
        $('#state').change(function() {
            $('#city').html('');
            sid = $(this).val();
            _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //console.log(data);
                        var option = '<option value="" disabled selected >Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $('#city').html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });

        $('#state11').change(function() {
            $('#city11').html('');
            sid = $(this).val();
            _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //console.log(data);
                        var option = '<option value="" disabled selected >Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $('#city11').html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        @endif

        @if(Route::has('state.get.city'))
        $("#contact_persons").on('change', '.state', function() {
            var $citySelect = $(this).closest('.row').find('.city');
            $citySelect.html('');
            var sid = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        var option = '<option value="" disabled selected>Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $citySelect.html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        @endif

        @if(Route::has('state.get.city'))
        $('#b_state').change(function() {
            $('#b_city').html('');
            sid = $(this).val();
            _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //console.log(data);
                        var option = '<option value="" disabled selected >Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $('#b_city').html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        @endif

        @if(Route::has('state.get.city'))
        $('#a_state').change(function() {
            $('#a_city').html('');
            sid = $(this).val();
            _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //console.log(data);
                        var option = '<option value="" disabled selected >Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $('#a_city').html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        @endif

        @if(Route::has('state.get.city'))
        $('#s_state').change(function() {
            $('#s_city').html('');
            sid = $(this).val();
            _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('state.get.city') }}",
                data: {
                    sid: sid,
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        //console.log(data);
                        var option = '<option value="" disabled selected >Select City</option>';
                        data.forEach(function(optionData) {
                            option += '<option value="' + optionData.id + '">' + optionData
                                .city_name + '</option>';
                        });
                        $('#s_city').html(option);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        @endif


        @if(Route::has('location_add'))
        $('#submitAddress').click(function(e) {
            e.preventDefault();

            if ($("#locationAddForm").valid()) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('location_add') }}",
                    data: $('#locationAddForm').serialize(),
                    success: function(response) {
                        if (response.status == true) {
                            $("#messageModal").removeClass('hide');
                            $("#messageModal").html('<span class="text-success p-2">' + response
                                .message + '</span>');
                            setTimeout(function() {
                                $("#modalToggle").modal('hide');
                            }, 2000);

                            $('#tabledata').html('');
                            var tblData = response.data;
                            var option = '';
                            tblData.forEach(function(optionData) {
                                option += '<tr><td>' + optionData.name + '</td><td>' +
                                    optionData.address +
                                    '</td><td><a class="" href="javascript:void(0)" onclick="deleteAddress(' +
                                    optionData.id + ',' + optionData.client_id +
                                    ')"><i class="bx bx-trash me-2 text-danger" style="font-size: 20px;"></i></a></td></tr>';
                            });
                            $('#tabledata').html(option);

                            //$('#tabledata').html(option);

                        } else {
                            $("#messageModal").removeClass('hide');
                            $("#messageModal").html('<span class="text-danger p-2">' + response
                                .message + '</span>');
                        }
                    },
                });
            }
        });
        @endif

        $("#locationAddForm").validate({
            rules: {
                a_name: {
                    required: true,
                },
                a_state: {
                    required: true,
                },
                a_city: {
                    required: true,
                },
                a_pincode: {
                    required: true,
                },
                a_address1: {
                    required: true,
                },
                a_address2: {
                    required: true,
                },
            },
            messages: {
                a_name: {
                    required: "Please enter address title properly",
                },
                a_state: {
                    required: "Please select state",
                },
                a_city: {
                    required: "Please select city",
                },
                a_pincode: {
                    required: "Please enter pincode",
                },
                a_address1: {
                    required: "Please enter address",
                },
                a_address2: {
                    required: "Please enter address",
                },
            },
        });

        @if(Route::has('location_delete'))
        function deleteAddress(id, cid) {
            var _token = $('input[name="_token"]').val();
            if (confirm("Do you want to delete this address?")) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('location_delete', 'id') }}".replace('id', id),
                    data: {
                        id: id,
                        cid: cid,
                        _token: _token
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $("#messageTable").removeClass('hide');
                            $("#messageTable").html('<span class="text-success p-2">' + response
                                .message + '</span>');
                            setTimeout(function() {
                                $("#messageTable").addClass('hide');
                            }, 3000);

                            $('#tabledata').html('');
                            var tblData = response.data;
                            var option = '';
                            tblData.forEach(function(optionData) {
                                option += '<tr><td>' + optionData.name + '</td><td>' +
                                    optionData.address +
                                    '</td><td><a class="" href="javascript:void(0)" onclick="deleteAddress(' +
                                    optionData.id + ',' + optionData.client_id +
                                    ')"><i class="bx bx-trash me-2 text-danger" style="font-size: 20px;"></i></a></td></tr>';
                            });
                            $('#tabledata').html(option);

                        } else {
                            $("#messageTable").removeClass('hide');
                            $("#messageTable").html('<span class="text-danger p-2">' + response
                                .message + '</span>');
                        }
                    }
                });
            }
        }
        @endif


        $(document).ready(function() {
            if ($('#makesame').prop('checked')) {
                $('#shippingSame').addClass('hide');
            }

            $('#makesame').change(function() {
                if ($(this).prop('checked')) {
                    $('#shippingSame').addClass('hide');
                    $('#country').removeAttr('required');
                    $('#state').removeAttr('required');
                    $('#city').removeAttr('required');
                    $('#pincode').removeAttr('required');
                    $('#address1').removeAttr('required');
                    $('#address2').removeAttr('required');
                } else {
                    $('#shippingSame').removeClass('hide');
                    $('#country').attr('required', 'required');
                    $('#state').attr('required', 'required');
                    $('#city').attr('required', 'required');
                    $('#pincode').attr('required', 'required');
                    $('#address1').attr('required', 'required');
                    $('#address2').attr('required', 'required');
                }
            });
        });

        @if(Route::has('department-machine-find'))
        $('#selDepartment').change(function() {
    $('#deptMachineData').html('');
    var sid = $(this).val();
    var _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        url: "{{ route('department-machine-find') }}",
        data: {
            sid: sid,
            _token: _token
        },
        success: function(response) {
            if (response && $.isEmptyObject(response.error)) {
                var html = '';
                $.each(response, function(index, machine) {
                    html += '<tr>';
                    html += '<td>' + machine.name + '</td>';
                    html += '<td>' + machine.machine_code + '</td>';
                    html += '<td>' + machine.department_id + '</td>';
                    html += '<td>' + machine.machine_type + '</td>';
                    html += '<td>' + machine.machine_model + '</td>';

                    html += '<td><a class="" title="View" data-bs-toggle="modal" data-bs-target="#basicModal' + machine.id + '" href="javascript:void(0)"><i class="bx bx-show me-2 text-success" style="font-size: 20px;"></i></a></td>';
                    html += '</tr>';
                });
                $('#deptMachineData').html(html);
            } else {
                $('#deptMachineData').html('<tr><td colspan="5">No data available</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
        @endif

    </script>

</body>

</html>
