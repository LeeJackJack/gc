<div class="container" id="cx_people" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <!-- 富文本编辑器 -->
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <script id="cx_people_ueditor" name="cx_people_ueditor" type="text/plain">请输入创新人内容...</script>
                        @if(isset($product))
                            <code id="cx_people_con" style="display:none;">
                                {!! $product->cx_people !!}
                            </code>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('#cx_people_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#product_basic_nav').removeClass('active');
        $('#cx_tech_nav').removeClass('active');
        $('#cx_story_nav').removeClass('active');
        $('#cx_principle_nav').removeClass('active');

        $('#product_basic').fadeOut(200);
        $('#cx_people').fadeIn(200);
        $('#cx_principle').fadeOut(200);
        $('#cx_story').fadeOut(200);
        $('#cx_tech').fadeOut(200);
    });

    //实例化编辑器
    var cx_people_ue = UE.getEditor('cx_people_ueditor', {
        initialFrameHeight: 700,
    });

    if ('{{isset($product)}}') {
        cx_people_ue.ready(function () {
            cx_people_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            cx_people_ue.setContent($('#cx_people_con').html());
        });
    } else {
        cx_people_ue.ready(function () {
            cx_people_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    }
</script>