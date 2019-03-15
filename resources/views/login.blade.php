@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-5">
		<div class="card ">
			<div class="card-header text-center">
				<img src="{{ asset('images/logo_vnpt.png') }}" width="142px" alt="">
			</div>
			<div class="card-body">
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="form-group">
						<input class="form-control-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
						@if ($errors->has('email'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group">
						<input class="form-control-lg form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" type="password" placeholder="Password" required>
						@if ($errors->has('password'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block">Đăng nhập</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection