<div class="mb-3">
    <label class="form-label">{{ __('Limit') }}</label>
    {!! Form::input('number', 'limit', Arr::get($attributes, 'limit', 5), ['class' => 'form-control']) !!}
</div>
