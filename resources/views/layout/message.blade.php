@if( Session::has('success') )
    <div class="content message-tips">
        <div class="Huialert Huialert-success"><span class="icon-remove">×</span>{{ Session::get('success') }}</div>
    </div>
@endif
@if( Session::has('error') )
    <div class="content message-tips">
        <div class="Huialert Huialert-danger"><span class="icon-remove">×</span>{{ Session::get('error') }}</div>
    </div>
@endif