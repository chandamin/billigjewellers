@extends('shopify-app::layouts.default')

@section('content')


<link rel="stylesheet" href="{{ asset('public/assets/css/polaris.css') }}?v=<?php echo rand(); ?>">
<link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}?v=<?php echo rand(); ?>">
<br><br>
<a href="{{route('checksettings')}}"><button class="btn btn-primary">@lang('lang.Checkout settings')</button></a>
<a href="{{route('add')}}"><button class="btn btn-primary">@lang('lang.Payment method')</button></a>
<div class="Polaris-LegacyCard">

  <div class="Polaris-CalloutCard__Container">
    <div class="Polaris-LegacyCard__Section Polaris-LegacyCard__FirstSectionPadding Polaris-LegacyCard__LastSectionPadding">
      <div class="Polaris-CalloutCard">
        <div class="Polaris-CalloutCard__Content">
          <div class="Polaris-CalloutCard__Title">
            <h2 class="Polaris-Text--root Polaris-Text--headingSm">@lang('lang.Welcome'): {{ $shopDomain ?? Auth::user()->name }}</h2>
          </div>
          <span class="Polaris-Text--root Polaris-Text--bodyMd">
            <div class="Polaris-BlockStack" style="--pc-block-stack-order:column">
              <p>@lang('lang.You can enable or disable your custom Plexo gateway here')</p>
            </div>
          </span>

          <form id="gateway-form" enctype="multipart/form-data">
            <div class="Polaris-FormLayout">
              <div class="Polaris-FormLayout__Item gateway">
                <label for="gateway_status" class="Polaris-Label">@lang('lang.Plexo Gateway')</label>
                <!-- <label class="Polaris-Checkbox">
                  <input type="checkbox" name="gateway_status" id="gateway_status" class="Polaris-Checkbox__Input" {{ $gatewayEnabled ? 'checked' : '' }}>
                  <span class="Polaris-Checkbox__Backdrop"></span>
                </label> -->

                <label class="switch">
                  <input type="checkbox" name="gateway_status"  id="gateway_status" {{ $gatewayEnabled ? 'checked' : '' }}>
                  <span class="slider round"></span>
                </label>
              </div>

              <div class="Polaris-FormLayout__Item username">
                <label for="username" class="Polaris-Label">@lang('lang.Name')</label>
                <input type="text" name="username" id="username" class="Polaris-TextField__Input" value="{{ $username ?? '' }}" required>
              </div>

              <div class="Polaris-FormLayout__Item password">
                <label for="password" class="Polaris-Label">@lang('lang.Password')</label>
                <input type="password" name="password" id="password" class="Polaris-TextField__Input" value="{{ $password ?? '' }}" required>
              </div>

              <div class="Polaris-FormLayout__Item pfx">
                <label for="pfx_file" class="Polaris-Label">@lang('lang.Upload PFX File')</label>
                <input type="file" name="pfx_file" id="pfx_file" class="Polaris-FileUpload__Input" accept=".pfx">
              </div>

              <div class="Polaris-FormLayout__Item submit">
                <button type="submit" id="submitBtn" class="Polaris-Button Polaris-Button--primary">@lang('lang.Submit')</button>
              </div>
            </div>
          </form>
           <!-- Horizontal line -->
          <hr style="margin: 20px 0; border: 1px solid #ccc;">
          <!-- Issuers  -->
          <div class="Polaris-LegacyCard__Section">
          <h3 class="Polaris-Text--root Polaris-Text--headingMd" style="font-weight: bold; text-align: center;">@lang('lang.Payment Methods')</h3>
            <div class="Polaris-BlockStack" style="--pc-block-stack-order:column">
              <p>@lang('lang.You can enable or disable your custom Payment Methods here')</p>
            </div>
            <div class="Polaris-DataTable">
              <div class="Polaris-DataTable__ScrollContainer">
                <table class="Polaris-DataTable__Table">
                  <thead>
                    <tr>
                      <th>@lang('lang.Name')</th>
                      <th>@lang('lang.Issuer ID')</th>
                      <th>@lang('lang.Commerce ID')</th>
                      <th>@lang('lang.Status')</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($issuers as $issuer)
                    <tr>
                      <td>{{ $issuer->name }}
                      <img src="https://static.plexo.com.uy/issuers/{{$issuer->issuer_id}}.svg" alt="" class="issuer-image" style="height: 30px;width: 50px;">
                      </td>
                      <td>{{ $issuer->issuer_id }}</td>
                      <td>{{ $issuer->commerce_id }}</td>
                      <td>
                        <label class="switch">
                          <input type="checkbox" class="issuer-toggle" data-id="{{ $issuer->id }}" {{ $issuer->status ? 'checked' : '' }}>
                          <span class="slider round"></span>
                        </label>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@parent
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#gateway-form').on('submit', function(e) {
      e.preventDefault();

      var formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('gateway_status', $('#gateway_status').is(':checked') ? 1 : 0);
      formData.append('username', $('#username').val());
      formData.append('password', $('#password').val());
      formData.append('pfx_file', $('#pfx_file')[0].files[0]);

      $.ajax({
        url: "{{ route('settings.update.gateway') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert('Details saved successfully');
        },
        error: function(error) {
          console.error('Error:', error);
          alert('Error saving details');
        }
      });
    });

    // Handle the toggle update on change
    $('#gateway_status').change(function() {
      $.ajax({
        url: "{{ route('settings.toggle.gateway') }}",
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          gateway_status: $(this).is(':checked') ? 1 : 0
        },
        success: function(response) {
          console.log(response.message);
        },
        error: function(error) {
          console.error('Error:', error);
        }
      });
    });
  });

  $(document).ready(function() {
  $('.issuer-toggle').change(function() {
    var issuerId = $(this).data('id');
    var $toggle = $(this);
    $.ajax({
      url: '{{ route("issuers.toggle", ":id") }}'.replace(':id', issuerId),
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        status: $(this).is(':checked') ? 1 : 0
      },
      success: function(response) {
        console.log('Issuer status updated');
      },
      error: function(xhr, status, error) {
        console.error('Error updating issuer status:', error);
        alert('Error updating issuer status: ' + xhr.responseText);
        $toggle.prop('checked', !$toggle.prop('checked'));
      }
    });
  });
});
</script>
@endsection