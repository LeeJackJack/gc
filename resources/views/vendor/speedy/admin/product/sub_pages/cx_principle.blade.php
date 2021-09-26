<div class="container" id="cx_principle" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <!-- 富文本编辑器 -->
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <script id="cx_principle_ueditor" name="cx_principle_ueditor" type="text/plain">请输入创新道内容...</script>
                        @if(isset($product))
                            <code id="cx_principle_con" style="display:none;">
                                {!! $product->cx_principle !!}
                            </code>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('#cx_principle_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#product_basic_nav').removeClass('active');
        $('#cx_tech_nav').removeClass('active');
        $('#cx_story_nav').removeClass('active');
        $('#cx_people_nav').removeClass('active');

        $('#product_basic').fadeOut(200);
        $('#cx_people').fadeOut(200);
        $('#cx_principle').fadeIn(200);
        $('#cx_story').fadeOut(200);
        $('#cx_tech').fadeOut(200);
    });

    //实例化编辑器
    var cx_principle_ue = UE.getEditor('cx_principle_ueditor', {
        initialFrameHeight: 700,
    });

    if ('{{isset($product)}}') {
        cx_principle_ue.ready(function () {
            cx_principle_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            cx_principle_ue.setContent($('#cx_principle_con').html());
        });
    } else {
        cx_principle_ue.ready(function () {
            cx_principle_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    }
</script>