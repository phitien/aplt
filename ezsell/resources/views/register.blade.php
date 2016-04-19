@extends('layouts.master')

@section('title', 'EZSell')

@section('css')
	@parent
@endsection

@section('script')
	@parent
	<script type="text/babel" src="js/pages/register.js"></script>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
	<script type="text/babel">
      var ExampleApplication = React.createClass({
        render: function() {
          var elapsed = Math.round(this.props.elapsed  / 100);
          var seconds = elapsed / 10 + (elapsed % 10 ? '' : '.0' );
          var message =
            'React has been successfully running for ' + seconds + ' seconds.';

          return <p>{message}</p>;
        }
      });
      var start = new Date().getTime();
      setInterval(function() {
        ReactDOM.render(
          <ExampleApplication elapsed={new Date().getTime() - start} />,
          document.getElementById('container')
        );
      }, 50);
    </script>
@endsection