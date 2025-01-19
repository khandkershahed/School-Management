<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">

    <!-- Meta Title and Description -->
    <meta name="title" content="{{ optional($setting)->site_title ?: config('app.name', 'AWS "|" Dashboard') }}">
    <meta name="description" content="{{ optional($setting)->meta_description ?: config('app.name') }}">
    <link rel="shortcut icon" href="asset('images/logo_color_no_bg.png')" />
    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ optional($setting)->site_url ?: config('app.url') }}">
    <meta property="og:title" content="{{ optional($setting)->site_title ?: config('app.name', 'AWS "|" Dashboard') }}">
    <meta property="og:description" content="{{ optional($setting)->meta_description ?: config('app.name') }}">
    <meta property="og:image"
        content="{{ optional($setting)->site_black_logo && file_exists(public_path('storage/' . $setting->site_black_logo)) ? asset('storage/' . $setting->site_black_logo) : asset('frontend/images/brandPage-logo-no-img(217-55).jpg') }}" />

    <!-- Twitter Meta Tags -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ optional($setting)->site_url ?: config('app.url') }}">
    <meta property="twitter:title"
        content="{{ optional($setting)->site_title ?: config('app.name', 'AWS "|" Dashboard') }}">
    <meta property="twitter:description" content="{{ optional($setting)->meta_description ?: config('app.name') }}">
    <meta property="twitter:image"
        content="{{ optional($setting)->site_black_logo && file_exists(public_path('storage/' . $setting->site_black_logo)) ? asset('storage/' . $setting->site_black_logo) : asset('frontend/images/brandPage-logo-no-img(217-55).jpg') }}" />

    <!-- Page Title -->
    <title>{{ optional($setting)->site_title ?: config('app.name', 'AWS "|" Dashboard') }}</title>

    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/bootstrap-icons@1.11.0.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/css/intlTelInput.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/apexcharts.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jsvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/jquerydatatable.css') }}">
    <style>
        th {
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" onload="myFunction()">
    <div class="spinner" id="loading">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <!-- App Wrapper -->
    <div class="app-wrapper">
        <!-- Include Header -->
        @include('admin.layouts.header')

        <!-- Include Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <main class="app-main">
            <!-- Error Alert Messages -->
            @if (session('error'))
                @foreach ($messages as $item)
                    <div class="alert alert-danger">
                        {{ $item }}
                    </div>
                @endforeach
            @endif
            <!-- Main Slot for Page Content -->
            {{ $slot }}
        </main>

        <!-- Include Footer -->
        @include('admin.layouts.footer')
    </div>

    <!-- JavaScript Files -->
    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/overlayscrollbars.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sortable.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/world.js') }}"></script>
    <script src="{{ asset('admin/assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/assets/js/alpinejs@3.x.x.js') }}"></script>
    <script src="{{ asset('admin/assets/js/html2pdf.js') }}"></script>
    <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('admin/assets/js/fontawesome6.js') }}"></script>
    <script src="{{ asset('admin/assets/js/adminlte.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <!-- Select2 -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/intlTelInput.min.js"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script>
        var preloader = document.getElementById('loading');

        function myFunction() {
            preloader.style.display = "none";
        }
        $(document).ready(function() {
            // $('.select2').select2()
            var allowClear = $(this).data("allow-clear") === "true"; // Read data attribute

            $('.select2').select2({
                allowClear: allowClear, // Use the parsed allowClear value
                width: "100%",
                placeholder: "Select an option",
            });

            $('.modal').on('shown.bs.modal', function() {
                $('.select2').select2({
                    allowClear: allowClear,
                    width: "100%",
                    placeholder: "Select an option",
                    dropdownParent: $(this),
                });
            });


            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>

    @include('toastr')
    @stack('scripts')

    <script>
        var table;

        // Initialize DataTable only after the document is fully loaded
        $(document).ready(function() {
            table = $('#datatable').DataTable();
        });

        function printInvoice() {
            // Temporarily disable DataTable to make the table a normal static table
            if (typeof table !== "undefined") {
                table.destroy(); // Remove DataTable features
            }

            // Create an iframe element
            var iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = 'none';
            document.body.appendChild(iframe);

            // Access the iframe's document
            var iframeDoc = iframe.contentWindow.document;

            // Create and append the print-friendly styles to the iframe
            var style = iframeDoc.createElement('style');
            style.innerHTML = `
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        padding: 8px;
                        text-align: center;
                        border: 1px solid #ddd;
                    }
                `;
            iframeDoc.head.appendChild(style);

            // Clone the content from the print container and append it to the iframe
            var printContents = document.getElementById('printContainer').innerHTML;
            iframeDoc.body.innerHTML = printContents;

            // Focus on the iframe and print the content
            iframe.contentWindow.focus();
            iframe.contentWindow.print();

            // After printing, remove the iframe and reinitialize DataTable
            iframe.contentWindow.onafterprint = function() {
                document.body.removeChild(iframe); // Remove iframe after printing
                $(document).ready(function() {
                    table = $('#datatable').DataTable(); // Reinitialize DataTable
                });
            };
        }
    </script>


    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            // if (
            //     sidebarWrapper &&
            //     typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            // ) {
            //     OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            //         scrollbars: {
            //             theme: Default.scrollbarTheme,
            //             autoHide: Default.scrollbarAutoHide,
            //             clickScroll: Default.scrollbarClickScroll
            //         }
            //     });
            // }
        });
    </script>
    <script>
        document.querySelectorAll('.ckeditor').forEach(element => {
            if (!element.classList.contains('ck-editor__editable_inline')) {
                ClassicEditor
                    .create(element)
                    .then(editor => {
                        console.log('CKEditor initialized:', editor);
                    })
                    .catch(error => {
                        console.error('CKEditor initialization error:', error);
                    });
            }
        });
    </script>
    <script>
        //  DropZone Image
        $(document).ready(function() {
            var selectedFiles = [];

            $(".dropzone-field").on("change", "#files", function(e) {
                var files = e.target.files,
                    filesLength = files.length;

                $(".custom-file-upload").toggle(filesLength === 0 && selectedFiles.length === 0);

                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    selectedFiles.push(f);
                    var fileReader = new FileReader();
                    fileReader.onload = (function(file) {
                        return function(e) {
                            $("<div class=\"img-thumb-wrapper card shadow\">" +
                                "<img class=\"img-thumb\" src=\"" + e.target.result +
                                "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove</span>" +
                                "</div>").insertAfter("#files");
                        };
                    })(f);
                    fileReader.readAsDataURL(f);
                }
                // console.log(selectedFiles);
                $(".existing-images").show();
            });

            // Use event delegation for the click event
            $(".dropzone-field").on("click", ".remove", function() {
                var wrapper = $(this).parent(".img-thumb-wrapper");
                wrapper.remove();
                var removedFile = wrapper.find('img').prop('title');
                selectedFiles = selectedFiles.filter(function(file) {
                    return file.name !== removedFile;
                });
                updateInputFiles();
                $(".custom-file-upload").toggle(selectedFiles.length === 0);
                // alert(selectedFiles.length);
            });

            function updateInputFiles() {
                // Create a new set of files excluding the removed one
                var newInputFiles = new DataTransfer();
                selectedFiles.forEach(function(file) {
                    newInputFiles.items.add(file);
                });

                // Clear the input
                $("#files").val("");

                // Assign the new set of files to the input
                $("#files")[0].files = newInputFiles.files;
            }
        });
        // checkbox And Select
        document.addEventListener('DOMContentLoaded', function() {

            const $selectAllCheckbox = $('.metronic_select_all');
            const $categoryCheckboxes = $('.bulkDelete-checkbox');
            const $deleteButton = $('#bulkDelete');

            function updateDeleteButtonVisibility() {
                // Check if any checkbox is checked
                const anyChecked = $categoryCheckboxes.is(':checked');
                $deleteButton.toggle(anyChecked);
            }

            // Handle 'Select All' checkbox change
            $selectAllCheckbox.on('change', function() {
                $categoryCheckboxes.prop('checked', $(this).prop('checked'));
                updateDeleteButtonVisibility();
            });

            // Handle individual checkbox changes
            $categoryCheckboxes.on('change', function() {
                updateDeleteButtonVisibility();
            });

            // Initial check to set the button visibility correctly
            updateDeleteButtonVisibility();
        });
        // Data table
        class DataTableInitializer {
            constructor(selector) {
                this.selector = selector;
                this.init();
            }

            init() {
                $(this.selector).DataTable({
                    "fixedHeader": {
                        "header": true,
                        "headerOffset": 5
                    },
                    "language": {
                        "lengthMenu": "Show _MENU_",
                    },
                    "dom": "<'row mb-2'" +
                        "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                        ">" +
                        "<'table-responsive'tr>" +
                        "<'row'" +
                        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            }
        }

        // Initialize DataTables for elements with class 'my-datatable'
        $(document).ready(function() {
            new DataTableInitializer('.my-datatable');
        });
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 10000;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 10000;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 10000;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 10000;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            $('#addModal').modal('hide');
            // Reset form
            // $('#addEntryForm')[0].reset();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sidebarToggler').addEventListener('click', function(e) {
                e.preventDefault();

                // Toggle sidebar visibility
                const sidebar = document.querySelector(
                    '#sidebar'); // Ensure you have this ID on your sidebar
                if (sidebar) {
                    sidebar.classList.toggle('hidden'); // Add/remove the hidden class on sidebar
                }

                // Toggle arrow icons
                document.getElementById('arrowLeft').classList.toggle('d-none');
                document.getElementById('arrowRight').classList.toggle('d-none');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all <select> elements with the data-allow-clear attribute
            const selectElements = document.querySelectorAll('select[data-allow-clear="true"]');

            selectElements.forEach(selectElement => {
                selectElement.addEventListener('change', function() {
                    // Check if clear is allowed
                    const allowClear = selectElement.getAttribute('data-allow-clear') === 'true';

                    if (allowClear && this.value === "") {
                        // Logic to handle clearing the selection
                        this.selectedIndex = 0; // Reset to the first option
                    }
                });
            });
        });
    </script>

</body>

</html>
