<div class="container" id="talent_contact" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    @if(count($talent->contacts))
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover"
                                   style="text-align: center;table-layout: fixed;">
                                <thead>
                                <tr class="active">
                                    <th style="text-align: center" width="10%">{{ trans('view.admin.talent.contact_name') }}</th>
                                    <th style="text-align: center" width="60%">{{ trans('view.admin.talent.contact_content') }}</th>
                                    <th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_created_at') }}</th>
                                    <th style="text-align: center" width="15%">{{ trans('view.admin.talent.contact_updated_at') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($talent->contacts as $contact)
                                    <tr>
                                        <td style="vertical-align: middle;">{{ $contact->name }}</td>
                                        <td style="vertical-align: middle;text-align: left;padding: 15px;">{!! $contact->content !!}</td>
                                        <td style="vertical-align: middle;">{{ $contact->created_at}}</td>
                                        <td style="vertical-align: middle;">{{ $contact->updated_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-sm-12">
                            暂无内容...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#talent_contact_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#talent_basic_nav').removeClass('active');
        $('#talent_wanted_job_nav').removeClass('active');
        $('#upload_resume_nav').removeClass('active');

        $('#talent_contact').fadeIn(200);
        $('#talent_basic').fadeOut(200);
        $('#talent_wanted_job').fadeOut(200);
        $('#upload_resume').fadeOut(200);

    });

</script>