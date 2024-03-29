@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Name</label>
                    	    <div class="col-md-6">
                    	        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">E-Mail Address</label>
                    	    <div class="col-md-6">
                    	        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Alternative E-Mail Address</label>
                    	    <div class="col-md-6">
                    	        <input type="email" class="form-control" name="alt_email" value="{{ old('alt_email') }}">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Password</label>
                    	    <div class="col-md-6">
                    	        <input type="password" class="form-control" name="password">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Confirm Password</label>
                    	    <div class="col-md-6">
                    	        <input type="password" class="form-control" name="password_confirmation">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Institution</label>
                    	    <div class="col-md-6">
                    	        <select class="form-control" name="institution">
                    	            @foreach ($institutions as $institution)
                    	                @if(old('institution') == $institution->id)
                    	                    <option value="{{ $institution->id }}" selected> {{ $institution->name }} </option>
                    	                @else
                    	                    <option value="{{ $institution->id }}"> {{ $institution->name }} </option>
                    	                @endif
                    	            @endforeach
                    	        </select>
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Position</label>
                    	    <div class="col-md-6">
                    	        <input type="text" class="form-control" name="position" value="{{ old('position') }}">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <label class="col-md-4 control-label">Profile URL</label>
                    	    <div class="col-md-6">
                    	        <input type="url" class="form-control" name="profile_url" value="{{ old('profile_url') }}">
                    	    </div>
                    	</div>
	
                    	<div class="form-group">
                    	    <div class="col-md-6 col-md-offset-4">
                    	        <button type="submit" class="btn btn-primary">
                    	            Create User
                    	        </button>
                    	    </div>
                    	</div>
                	</form>

					<!--<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Institution</label>
							<div class="col-md-6">
								<select class="form-control" name="institution">
									@foreach ($institutions->all() as $institution)
										@if(old('institution') == $institution->id)
											<option value="{{ $institution->id }}" selected> {{ $institution->name }} </option>
										@else
											<option value="{{ $institution->id }}"> {{ $institution->name }} </option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>-->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
