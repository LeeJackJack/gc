<style>
    .container {
        font-size: 14px;
        color: #333333;
        letter-spacing: 2px;
        line-height: 30px;
    }
    .email_pic{
        width: 100%;
    }
</style>
<div class="container">
    {{--<img src="https://bocuhui.oss-cn-beijing.aliyuncs.com/images/banner1.png" alt="" class="email_pic">--}}
    <p>您好，我是广东省博士博士后人才发展促进会秘书处，
        我们在“博士博士后创新中心”小程序收到 {{ $name  }} 博士对贵单位的投递申请需求，
        意向岗位是 {{ $job }}。以下是 {{ $name  }} 博士的相关信息。</p>
    <p>姓名：{{ $name  }} </p>
    <p>专业：{{ $major }}</p>
    <p>毕业学校：{{ $school  }}</p>
    <p>联系电话：{{ $phone  }}</p>
    <p>Email：{{ $email  }}</p>
    <p>感谢您对平台的支持！祝，生活愉快。</p>
    <p></p>
    <p>--</p>
    <p>广东省博士博士后人才发展促进会秘书处</p>
    <p>联系电话：020-32166009</p>
</div>
