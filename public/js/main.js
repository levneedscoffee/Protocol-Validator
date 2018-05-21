
$("button").click(function(){
    var idName = this.id;
    var arrayId = idName.split(' ');
    var commandTag = arrayId[0];
    var errorNum = arrayId[1];
    var json = JSONarray[commandTag][errorNum];
    $('textarea[name="request"]').val(JSON.stringify(json, null, 5));
});
$("document").ready(function(){
    $("form").submit(function (e){
        $.ajax({
            url: '',
            type: 'POST',
            data: {"request": $('textarea[name="request"]').val()},
            dataType: 'json',
            success: function(data){
                var json = JSON.stringify(data, null, 5);
                $('#response').val(json);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("error");
                console.log(xhr.status);
                console.log(xhr.statusText);
                console.log(thrownError);
                console.log(ajaxOptions);
            }
        });
        e.preventDefault();
    })
})