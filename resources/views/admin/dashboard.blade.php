@extends('admin.maindesign')
@section('dashboard')
     <div class="container-fluid">
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-user-1"></i></div><strong>Clients</strong>
                    </div>
                    <div class="number dashtext-1">{{ $totalClients }}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $clientProgress }}%" aria-valuenow="{{ $clientProgress }}%" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                  <div class="progress-details d-flex align-items-end justify-content-between">
                    <div class="title">
                      <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Invoice</strong>
                    </div>
                    <div class="number dashtext-3">{{$totalInvoices}}</div>
                  </div>
                  <div class="progress progress-template">
                    <div role="progressbar" style="width: {{ $invoiceProgress }}%" aria-valuenow="{{ $invoiceProgress }}" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection