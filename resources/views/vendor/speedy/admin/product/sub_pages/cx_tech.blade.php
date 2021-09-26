<div class="container" id="cx_tech" style="display: none;">
    <div class="row">
        <div class="col-md-12">
            <!-- 富文本编辑器 -->
            <div class="form-horizontal">
                <div class="form-group">
                    <div class="col-sm-12">
                        <script id="cx_tech_ueditor" name="cx_tech_ueditor" type="text/plain">请输入创新术内容...</script>
                        @if(isset($product))
                            <code id="cx_tech_con" style="display:none;">
                                {!! $product->cx_tech !!}
                            </code>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $('#cx_tech_nav').click(function (e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#product_basic_nav').removeClass('active');
        $('#cx_story_nav').removeClass('active');
        $('#cx_principle_nav').removeClass('active');
        $('#cx_people_nav').removeClass('active');

        $('#product_basic').fadeOut(200);
        $('#cx_people').fadeOut(200);
        $('#cx_principle').fadeOut(200);
        $('#cx_story').fadeOut(200);
        $('#cx_tech').fadeIn(200);
    });

    //实例化编辑器
    var cx_tech_ue = UE.getEditor('cx_tech_ueditor', {
        initialFrameHeight: 700,
    });

    if ('{{isset($product)}}') {
        cx_tech_ue.ready(function () {
            cx_tech_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
            cx_tech_ue.setContent($('#cx_tech_con').html());
        });
    } else {
        cx_tech_ue.ready(function () {
            cx_tech_ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    }
</script>