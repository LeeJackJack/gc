<div class="container" id="job_qr_code" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <!-- 职位二维码-->
                        <div class="col-sm-6">
                            <div class="input-group">
                                <div id="show_qr_code">
                                    @if(isset($job->qr_code))
                                        <img id="qr_code_pic" src="{{$job->qr_code}}" alt="" class="img-rounded"
                                             style="width: 60%;">
                                    @else
                                        <button id="create_qr_code" type="button" class="btn btn-sm btn-info"
                                                onclick="create_qr_code();" data-loading-text="生成中...">生成
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#job_qr_code_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#job_basic_nav').removeClass('active');

        $('#job_qr_code').fadeIn(200);
        $('#job_basic').fadeOut(200);
    });

    function create_qr_code() {
        var $btn = $('#create_qr_code').button('loading')
        $.ajax({
            url: "/api/wx/getQrCode",
            method: "GET",
            data: {
                "scene": "{{$job->ids}}",
            },
            dataType: "json",
            success: function success(data) {
                $btn.button('reset');
                var content = '';
                content += '<img id="qr_code_pic" src="'+ data.url +'" alt="" class="img-rounded" style="width: 60%;">'
                $('#show_qr_code').html(content);
            },
            error: function error(error) {
                $btn.button('reset');
                var content = '';
                content += '生成失败，请稍后再尝试。'
                $('#show_qr_code').html(content);
            }
        });
    }

</script>