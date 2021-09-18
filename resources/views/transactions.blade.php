@include('layouts.head')

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    @forelse ($transactions as $key => $transaction)
    @if($transaction->payment_date != null)
    <div class="img-receipt" id="{{'receipt'.$key}}" onclick="closeReceipt({{$key}})">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <img src="{{asset('/img/images/receipt/'.$transaction->proof_of_payment)}}" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    @endif
    <div class="transaction-modal" id="{{'transaction-modal'.$key}}" name="{{'close-modal'.$key}}">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="row card justify-content-center mx-5 p-3">
                    <div class="col-sm-12">
                        <div class="row justify-content-between">
                            <div class="col-sm-3">
                                <div class="modal-status">
                                    {{$transaction->transaction_status}}
                                </div>
                            </div>
                            <div class="col-sm-3 my-auto">
                                <div class="row justify-content-end">
                                    <h4 class="font-weight-bold" onclick="closeModal({{$key}})" style="cursor:pointer;">
                                        X
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <h3 class="text-center">
                                Transaction Details
                            </h3>
                        </div>
                        <div class="row justify-content-center">
                            Transaction ID : {{$transaction->transaction_id}}
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-3 d-flex flex-column">
                                <h4>
                                    <i class="fas fa-user"></i>
                                    {{$transaction->customer->name}}
                                </h4>
                                <text>
                                    {{$transaction->customer->mobile_number}}
                                </text>
                            </div>
                            <div class="col-sm-2 my-auto mr-5">
                                <a href="{{route('message.indexTransaction',$transaction->customer->user_id)}}" class="btn-brand">
                                    Chat
                                </a>
                            </div>
                            @if ($transaction->admin_id && $user->user_type == 'seller')
                            <div class="col-sm-3 d-flex flex-column my-auto ml-5">
                                <h4>
                                    <i class="fas fa-user"></i>
                                    {{$transaction->admin->name}}
                                </h4>
                                <text>
                                    {{$transaction->admin->mobile_number}}
                                </text>
                            </div>
                            <div class="col-sm-2 my-auto">
                                <a href="{{route('message.indexTransaction',$transaction->admin->user_id)}}" class="btn-brand">
                                    Chat
                                </a>
                            </div>
                            @endif
                            @if ($user->user_type == 'admin')
                            <div class="col-sm-3 d-flex flex-column my-auto ml-5">
                                <h4>
                                    <i class="fas fa-user"></i>
                                    {{$transaction->seller->name}}
                                </h4>
                                <text>
                                    {{$transaction->seller->mobile_number}}
                                </text>
                            </div>
                            <div class="col-sm-2 my-auto">
                                <a href="{{route('message.indexTransaction',$transaction->seller->user_id)}}" class="btn-brand">
                                    Chat
                                </a>
                            </div>
                            @endif
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <div class="col-sm-3 d-flex flex-column">
                                <text>
                                    Checkout time :
                                </text>
                                <text>
                                    {{$transaction->created_at}}
                                </text>
                            </div>
                            @if ($transaction->payment_date)
                            <div class="col-sm-3 d-flex flex-column">
                                <text>
                                    Payment date :
                                </text>
                                <text>
                                    {{$transaction->payment_date}}
                                </text>
                            </div>
                            @endif
                            <div class="col-sm-3 d-flex flex-column">
                                <text>
                                    Status update time :
                                </text>
                                <text>
                                    {{$transaction->updated_at}}
                                </text>
                            </div>
                        </div>
                        <div class="row justify-content-start mt-3 mx-2">
                            Product
                        </div>
                        <div class="row">
                            <div class="col-sm-5 mr-5">
                                <div class="row my-auto justify-content-start">
                                    <div class="col-sm-4">
                                        <img src="{{asset('/img/images/products/'.$transaction->product->thumbnail->picture)}}"
                                            alt="" class="img-fluid">
                                    </div>
                                    <div class="col-sm-5">
                                        <h5>
                                            {{$transaction->product->product_name}}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 ml-5">
                                <div class="row my-auto justify-content-end">
                                    <h3>Total</h3>
                                </div>
                                <div class="row my-auto justify-content-end">
                                    <h2 class="text-end">
                                        Rp{{$transaction->transaction_total_cost}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4">
                            @if ($user->user_type == 'admin' || $user->user_type == 'principal')
                            <div class="col-sm-3">
                                <a class="btn w-100 {{$transaction->can_approve ? 'btn-primary':'btn-secondary'}}"
                                    href="{{$transaction->can_approve != null ? route('transaction.approve',$transaction->transaction_id):null}}"
                                    style="{{$transaction->can_approve != null ? '' : 'cursor:not-allowed;'}}">
                                    Approve Payment
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn w-100 {{$transaction->can_reject ? 'btn-danger':'btn-secondary'}}"
                                    href="{{$transaction->can_reject ? route('transaction.reject',$transaction->transaction_id):null}}"
                                    style="{{$transaction->can_reject ? '' : 'cursor:not-allowed;'}}">
                                    Reject Payment
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn w-100 {{$transaction->can_transfer_to_seller ? 'btn-danger':'btn-secondary'}}"
                                    href="{{$transaction->can_transfer_to_seller ? route('transaction.done',$transaction->transaction_id):null}}"
                                    style="{{$transaction->can_transfer_to_seller ? '' : 'cursor:not-allowed;'}}">
                                    Transfer Fund to Seller
                                </a>
                            </div>
                            @elseif($user->user_type == 'seller' || $user->user_type == 'principal')
                            <div class="col-sm-3">
                                <a class="btn w-100 {{$transaction->can_be_sent ? 'btn-primary':'btn-secondary'}}"
                                    href="{{$transaction->can_be_sent ? route('transaction.send',$transaction->transaction_id):null}}"
                                    style="{{$transaction->can_be_sent ? '' : 'cursor:not-allowed;'}}">
                                    Send Product
                                </a>
                            </div>
                            @endif
                            @if($transaction->payment_date != null)
                            <div class="col-sm-3">
                                <button class="btn w-100 btn-success" onclick="showReceipt({{$key}})">
                                    Payment Receipt
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="{{asset('asset/Navbar_logo.png')}}" alt="AdminLTELogo">
        </div>

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Transactions</h1>
                        </div>
                        <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                            @if ($user->user_type == 'customer')
                              <li class="breadcrumb-item"><a href="{{route('home.customer')}}">Home</a></li>
                            @elseif($user->user_type == 'seller')
                              <li class="breadcrumb-item"><a href="{{route('home.seller')}}">Home</a></li>
                            @elseif($user->user_type == 'admin' || $user->user_type == 'principal')
                              <li class="breadcrumb-item"><a href="{{route('home.admin')}}">Home</a></li>
                            @endif
                            <li class="breadcrumb-item active">Transactions</li>
                          </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-3">
                <div class="card-body p-5">
                    <table class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>
                                    Transaction ID
                                </th>
                                <th>
                                    Customer
                                </th>
                                @if ($user->user_type == 'admin')
                                <th>
                                    Seller
                                </th>
                                @endif
                                <th>
                                    Product
                                </th>
                                <th>
                                    Transaction Status
                                </th>
                                <th>
                                    Checkout Time
                                </th>
                                <th>
                                    Status Update Time
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $key => $transaction)
                            <tr>
                                <td>
                                    {{$transaction->transaction_id}}
                                </td>
                                <td>
                                    {{$transaction->customer->name}}
                                </td>
                                @if ($user->user_type == 'admin')
                                <td>
                                    {{$transaction->seller->name}}
                                </td>
                                @endif
                                <td>
                                    {{$transaction->product->product_name}}
                                </td>
                                <td>
                                    {{$transaction->transaction_status}}
                                </td>
                                <td>
                                    {{$transaction->created_at}}
                                </td>
                                <td>
                                    {{$transaction->updated_at}}
                                </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <button onclick="showModal({{$key}})" class="btn-brand">
                                            Details
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <strong><a href="/">WheelsJunkie.com </a></strong>
        </footer>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.js')}}"></script>
    <script src="{{asset('dist/js/demo.js')}}"></script>
    <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
    <script>
        function showModal(idx){
            var id = "transaction-modal"+idx;
            console.log(id);
            var modal = document.getElementById(id);
            modal.style.display = 'block';
        }
        function closeModal(idx){
            var id = "transaction-modal"+idx;
            console.log(id);
            var modal = document.getElementById(id);
            modal.style.display = 'none';
        }
        function showReceipt(idx){
            var id = "receipt"+idx;
            var img = document.getElementById(id);
            img.style.display = 'block';
        }
        function closeReceipt(idx){
            var id = "receipt"+idx;
            var img = document.getElementById(id);
            img.style.display = 'none';
        }
    </script>
</body>

</html>