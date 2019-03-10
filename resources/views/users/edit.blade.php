<div class="row">
    <div class="col">
        {!! Form::model($user, ['route' => 'user.update', 'method' => 'put']) !!}

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="name" class="control-label">Name
                    <span class="text-danger">*</span></label>
                {!! Form::text('name', null, [
                'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="credit_card" class="control-label">Credit cart number</label>
                {!! Form::text('credit_card', null, [
                'class' => 'form-control' . ($errors->has('credit_card') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('credit_card'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('credit_card') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="address_1" class="control-label">Address 1</label>
                {!! Form::text('address_1', null, [
                'class' => 'form-control' . ($errors->has('address_1') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('address_1'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address_1') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="address_2" class="control-label">Address 2</label>
                {!! Form::text('address_2', null, [
                'class' => 'form-control' . ($errors->has('address_2') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('address_2'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address_2') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="city" class="control-label">City</label>
                {!! Form::text('city', null, [
                'class' => 'form-control' . ($errors->has('city') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('city'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="region" class="control-label">Region</label>
                {!! Form::text('region', null, [
                'class' => 'form-control' . ($errors->has('region') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('region'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('region') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="postal_code" class="control-label">Postal Code</label>
                {!! Form::text('postal_code', null, [
                'class' => 'form-control' . ($errors->has('postal_code') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('postal_code'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('postal_code') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="shipping_region_id" class="control-label">Shipping Region</label>
                {!! Form::select('shipping_region_id', \App\Models\ShippingRegion::getAllIdsAndNames() , null , [
                'class' => 'form-control' . ($errors->has('shipping_region_id') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('shipping_region_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('shipping_region_id') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="country" class="control-label">Country</label>
                {!! Form::text('country', null, [
                'class' => 'form-control' . ($errors->has('country') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('country'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="day_phone" class="control-label">Day Phone</label>
                {!! Form::text('day_phone', null, [
                'class' => 'form-control' . ($errors->has('day_phone') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('day_phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('day_phone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="mob_phone" class="control-label">Mobile Phone</label>
                {!! Form::text('mob_phone', null, [
                'class' => 'form-control' . ($errors->has('mob_phone') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('mob_phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('mob_phone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group">
                <label for="eve_phone" class="control-label">Evening Phone</label>
                {!! Form::text('eve_phone', null, [
                'class' => 'form-control' . ($errors->has('eve_phone') ? ' is-invalid' : ''),
                ]) !!}
                @if ($errors->has('eve_phone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('eve_phone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-12">
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
