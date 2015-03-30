    $(function(){
        $('#construct_appbundle_service_file').change(function(){
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (this.files && this.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
            {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
            else
            {
                $('#img').attr('src', '/assets/no_preview.png');
            }
        });

    });