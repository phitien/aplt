@extends('layouts.master')

@section('title', 'EZSell - Chat')

@section('scripts')
@parent
	<script src="js/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/socket.io-1.3.4.js"></script>
@endsection

@section('content')
@parent
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Send message</div>
                    <form action="sendmessage" method="POST">
                        <input type="text" name="message" />
                        <input type="button" value="send" onclick="submitForm(this.parentElement)"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
