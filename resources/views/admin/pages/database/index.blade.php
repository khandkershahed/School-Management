<x-admin-app-layout :title="'Clients'">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <div class="app-content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-8 offset-2">
                    <div class="card border-0 shadow-none">
                        <div class="card-header p-3 bg-custom text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">Database Backup</h4>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row p-3">
                                <div class="col-12 mb-3">
                                    <x-admin.label for="status" class="form-label">Export Database</x-admin.label>
                                    <select class="form-select" name="" id="">
                                        <option value="">SQL (.sql)</option>
                                    </select>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="{{ route('admin.database.download') }}" class="btn btn-primary text-white">
                                        Export
                                        <i class="fa-solid fa-download ps-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
