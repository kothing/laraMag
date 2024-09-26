<div class="mb-3">
    <label class="form-label">{{ __('Limit') }}</label>
    {!! Form::input('number', 'limit', Arr::get($attributes, 'limit', 8), ['class' => 'form-control']) !!}
</div>
