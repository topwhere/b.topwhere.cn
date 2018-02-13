function getUrl(file,_img,img,width,height) {
    for (var intI = 0; intI < file.length; intI++) {//图片回显
        var tmpFile = file[intI];
        var reader = new FileReader();
        reader.readAsDataURL(tmpFile);
        reader.onload = function (e) {
            var base = e.target.result;

            $.post('/api/imgsave',{'base':base},function (e) {
                $('#'+img).val(e);
                tmp_img ='<span> <img class="file-manage" src="'+e+'"width="'+width+'" height="'+height+'"></span>';
                $('#'+_img).append(tmp_img)
            })
        }
    }
}