@extends('layouts.app')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.8/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.8/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.8/dist/js/uikit-icons.min.js"></script>
    <script src="symbol-sdk-2.0.4.min.js"></script>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Wallet') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    {{$user->name}}
                        <form action="/home" method="get">
                            <div style="margin-top:10px;">
                                Address:<input type="text" name="address" id="address" class="uk-input" value="{{$user->wallet}}">
                            </div>
                            <div style="margin-top:10px;">
                                Balance:<span id="balance">0</span> xym
                            </div>
                            <input type="submit" value="Address更新" class="uk-button uk-button-primary" style="margin-top:10px;">
                            @if ($user->wallet)
                            <div id="balance_get" class="uk-button uk-button-primary" style="margin-top:10px;">
                                残高取得
                            </div>
                            @endif
                        </form>
                        <br/>
                        <a href="https://line.me/R/ti/p/@ubt0802m">
                            <div class="uk-button uk-button-primary" style="margin-top:10px;">LINE</div>
                        </a>
                        <br/>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const symbol=require("/node_modules/symbol-sdk");
    let address;
    const nodeAddress='https://01.symbol-gentoo.tokyo:3001';
    const networkGenerationHash="57F7DA205008026C776CB6AED843393F04CD458E0AA2D9F1D5F31A402072B2D6";
    const repositoryFactory=new symbol.RepositoryFactoryHttp(nodeAddress);
    const accountHttp=repositoryFactory.createAccountRepository();

    $('#balance_get').click(function(){
        address=symbol.Address.createFromRawAddress($('#address').val());
        accountHttp.getAccountInfo(address)
            .subscribe(function(accountInfo){
                $('#balance').text(accountInfo.mosaics[0].amount.compact()/1000000);
                console.log(accountInfo.mosaics[0].id.toHex())
            }, err => console.error(err));
    });
</script>


@endsection
