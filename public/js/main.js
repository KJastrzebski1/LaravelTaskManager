/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(".alert-warning").hide();
$(".alert-success").hide();
$(".save").hide();

$(document).ready(function () {
    
    $(".delete").click(function () {
        var id = parseInt((this.id.replace('delete-task-', '')));
        localStorage.removeItem('TaskRepo' + id);
        $("tr#task-" + id).remove();
    });
    $(".edit").click(function () {
        var id = parseInt((this.id.replace('edit-task-', '')));
        var task = localStorage.getItem('TaskRepo' + id);

        task = task.split(',');
        $(this).hide();
        $('tr#task-' + id + " .save").show();
        $("tr#task-" + id + " .tname").html('<input type="text" name="name" class="form-control" value="' + task[1] + '">');
        $("tr#task-" + id + " .tdeadline").html('<input type="date" name="name"class="form-control" value="' + task[2] + '">');
        var status = '<select class="form-control" name="status">';
        for (var i = 0; i < 101; i += 10) {
            status += '<option value="' + i + '">' + i + '</option>';
        }
        status += '</select>';
        $("tr#task-" + id + " .tstatus").html(status);
        $("tr#task-" + id + " .tstatus select").val(task[3]);
        $("tr#task-" + id + " .tpriority").html('<select class="form-control" name="priority">' +
                '<option value="Low">Low</option>' +
                '<option value="Normal">Normal</option>' +
                '<option value="High">High</option>' +
                '<option value="Urgent">Urgent</option>' +
                '<option value="Immediate">Immediate</option>' +
                '</select>');
        $("tr#task-" + id + " .tpriority select").val(task[4]);
    });

    $(".save").click(function () {
        $(this).hide();
        var id = parseInt((this.id.replace('save-task-', '')));
        var task = [
            id,
            $("tr#task-" + id + " .tname input").val(),
            $("tr#task-" + id + " .tdeadline input").val(),
            $("tr#task-" + id + " .tstatus select").val(),
            $("tr#task-" + id + " .tpriority select").val()
        ];
        $("tr#task-" + id + " .tname").html('<div>' + task[1] + '</div>');
        $("tr#task-" + id + " .tdeadline").html('<div>' + task[2] + '</div>');
        $("tr#task-" + id + " .tstatus").html('<div>' + task[3] + '%</div>');
        $("tr#task-" + id + " .tpriority").html('<div>' + task[4] + '</div>');
        localStorage.setItem('TaskRepo' + id, task);
        $('tr#task-' + id + " .edit").show();
        console.log("saved");
    });

    window.addEventListener('load', function () {

        function updateOnlineStatus(event) {
            var status = navigator.onLine;
            if(status){
                $(".alert-success").show();
                //var task = localStorage.
            }else{
                $(".alert-warning").show();
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
    });
});
