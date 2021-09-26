<div id="elMessage">
</div>
<style>
	{{----}}
</style>
<script>
    let elMessage = new Vue({
        el: '#elMessage',
        data: {
            hasMessage:'{{Session::has('caffeinated.flash.message')}}',
            level:'{{ Session::get('caffeinated.flash.level') }}',
            message:'{{ Session::get('caffeinated.flash.message') }}',
        },
        compute: {
            //
        },
        methods: {
            showMessage() {
                // this.$notify({
                //     title:this.level,
                //     duration:5000,
                //     //showClose:true,
                //     message: this.message,
                //     type: this.level,
                //     //offset:17,
                // });
                this.$message({
                    duration:5000,
                    showClose:true,
                    message: this.message,
                    type: this.level,
                    offset:17,
                });
            },
        },
        created: function () {
            if (this.hasMessage)
            {
                if (this.level == 'danger')
                {
                    this.level = 'error';
                }
                this.showMessage();
            }
        },
        mounted: function () {
			//
        },
    });
</script>