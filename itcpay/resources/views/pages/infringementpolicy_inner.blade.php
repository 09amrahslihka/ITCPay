@extends('User.dashboard.layouts.master')
@section('title', 'Infringement Policy')
@section('content')
<div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
    <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Infringement Policy</h3>
        </div>
        <div class = 'row'>
            <div class="col-md-12">
                <div class="main-sub-section-content about_us_content">
                    <p><b style="font-size:18px;">License And Access</b></p>
                    <p>
                        {{ getSiteName() }} doesn’t grants complete rights (as mentioned in its Terms and Conditions) to you and are retained by {{ getSiteName() }}. You are not in any case or situation are allowed to use any proprietary information which includes graphics, layout, form, trademark or logos etc. without {{ getSiteName() }} consent (written). You (user) are bound not to misuse {{ getSiteName() }} services and you are use the same as applicable by law. If you know anyone or any third party using {{ getSiteName() }} services without our express consent can notify us as soon as possible.
                    </p>
                    <p><b style="font-size:18px;">Copyright</b></p>
                    <p>Any content whether graphic, artwork, form, logos etc.is property of {{ getSiteName() }} without any exceptions. The very same is protected by International Copyright laws and you are refrained from using, imitating, copying any {{ getSiteName() }} content without our written consent.</p>
                    <p><b style="font-size:18px;">Trademarks</b></p>
                    <p>
                        Every {{ getSiteName() }} registered or unregistered trademark, slogans, and logo cannot be used without {{ getSiteName() }}’s specific consent (written). Any or all trademarks which are not owned by {{ getSiteName() }} which appear in its service or on its website are the exclusive property of its owner whomsoever may that be. It can be somebody {{ getSiteName() }} is affiliated with or is sponsored by or connected to {{ getSiteName() }}. Misuse of any of our trademarks is prohibited and violation of {{ getSiteName() }} IPR (Intellectual Property Rights) will result in lawsuit against the guilty party which will include civil and criminal proceedings as necessary.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop