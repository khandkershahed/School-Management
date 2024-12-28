<x-admin-app-layout :title="'Client'">
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center mb-2">
                                @if ($client->image)
                                    <a href="#" id="show-modal">
                                        <img src="{{ asset('storage/'.$client->image) }}" class="profile-user-img img-fluid img-circle"
                                            loading="lazy" />
                                    </a>
                                @else
                                    <div class="bg-secondary no-preview-lg text-center">
                                        <small style="height: 100px;">{{ __('common.no_preview') }}</small>
                                    </div>
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ $client->name }}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <strong>{{ __('Client Id') }}</strong>
                                    <span class="float-right">{{ $client->client_id }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('Name') }}</strong>
                                    <span class="float-right">{{ $client->name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('Email') }}</strong>
                                    <span class="float-right">{{ $client->email }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('Contact Number') }}</strong>
                                    <span class="float-right">{{ $client->phoneNumber }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('Company Name') }}</strong>
                                    <span class="float-right">{{ $client->companyName }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('Address') }}</strong>
                                    <span class="float-right">{{ $client->address }}</span>
                                </li>
                            </ul>
                            @if ($client->status === 'active')
                                <span class="btn-block btn bg-success">{{ __('Active') }}</span>
                            @else
                                <span class="btn-block btn bg-danger">{{ __('In Active') }}</span>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                {{-- <div class="col-md-12 col-lg-9">
                    <div class="row">
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="card bg-info">
                                <div class="card-content">
                                    <div class="card-body pb-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="text-white">
                                                    {{ $t('common.invoice_total') }}
                                                </h6>
                                                <h6 class="text-white">
                                                    {{ $t('payments.common.non_invoice_total') }}
                                                </h6>
                                                <hr />
                                                <h4 class="text-white mb-1">{{ $t('common.total') }}</h4>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h6 class="text-white">

                                                </h6>
                                                <h6 class="text-white">
                                                    {{ (client . nonInvoiceDue) | withCurrency }}
                                                </h6>
                                                <hr />
                                                <h4 class="text-white mb-1">
                                                    {{ (client . clientInvoiceTotal + client . nonInvoiceDue) | withCurrency }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4 col-12">
                            <div class="card bg-danger">
                                <div class="card-content">
                                    <div class="card-body pb-1">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="text-white">{{ $t('common.invoice_due') }}</h6>
                                                <h6 class="text-white">
                                                    {{ $t('common.non_invoice_due') }}
                                                </h6>
                                                <hr />
                                                <h4 class="text-white mb-1">
                                                    {{ $t('common.total_due') }}
                                                </h4>
                                            </div>
                                            <div class="col-6 text-right">
                                                <h6 class="text-white">
                                                    {{ (client.clientDue) | withCurrency }}
                                                </h6>
                                                <h6 class="text-white">
                                                    {{ (client . nonInvoiceCurrentDue) | withCurrency }}
                                                </h6>
                                                <hr />
                                                <h4 class="text-white mb-1">
                                                    {{ (client . clientDue + client . nonInvoiceCurrentDue) | withCurrency }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-admin-app-layout>
