


$(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});

$(document).ready(function () {
    $(".task-table").on('click', '.delete', function () {
        var id = (this.id.replace('delete-task-', ''));
        deleteTask(id);
        $("tr#task-" + id).remove();
    });
    $(".task-table").on('click', '.edit', function () {
        var id = (this.id.replace('edit-task-', ''));
        var tasks = JSON.parse(localStorage.taskRepo);
        for (var i = 0; i < tasks.length; i++) {
            if (tasks[i]["id"] == id) {
                var task = tasks[i];
            }
        }

        $(this).hide();
        $('tr#task-' + id + " .save").show();
        $("tr#task-" + id + " .tname").html('<input type="text" name="name" class="form-control" value="' + task["name"] + '">');
        $("tr#task-" + id + " .tdeadline").html('<input type="date" name="name"class="form-control" value="' + task["deadline"] + '">');
        var status = '<select class="form-control" name="status">';
        for (var i = 0; i < 101; i += 10) {
            status += '<option value="' + i + '">' + i + '</option>';
        }
        status += '</select>';
        $("tr#task-" + id + " .tstatus").html(status);
        $("tr#task-" + id + " .tstatus select").val(task["status"]);
        $("tr#task-" + id + " .tpriority").html('<select class="form-control" name="priority">' +
                '<option value="Low">Low</option>' +
                '<option value="Normal">Normal</option>' +
                '<option value="High">High</option>' +
                '<option value="Urgent">Urgent</option>' +
                '<option value="Immediate">Immediate</option>' +
                '</select>');
        $("tr#task-" + id + " .tpriority select").val(task["priority"]);
    });

    $(".task-table").on('click', '.save', function () {
        $(this).hide();

        var id = (this.id.replace('save-task-', ''));

        var task = {
            'id': id,
            'name': $("tr#task-" + id + " .tname input").val(),
            'deadline': $("tr#task-" + id + " .tdeadline input").val(),
            'status': $("tr#task-" + id + " .tstatus select").val(),
            'priority': $("tr#task-" + id + " .tpriority select").val()
        };

        task = editTask(task);
        if (typeof task === 'object') {
            id = task.id;
            $("tr#task-" + id + " .tname").html('<div>' + task['name'] + '</div>');
            $("tr#task-" + id + " .tdeadline").html('<div>' + task['deadline'] + '</div>');
            $("tr#task-" + id + " .tstatus").html('<div>' + task['status'] + '%</div>');
            $("tr#task-" + id + " .tpriority").html('<div>' + task['priority'] + '</div>');

            $('tr#task-' + id + " .edit").show();
        }else{
            console.log(typeof task);
        }

    });

    $(".new-task").click(function () {
        var task = {
            'name': $('#task-name').val(),
            'deadline': $('#task-deadline').val(),
            'status': $('#task-status').val(),
            'priority': $('#task-priority').val()
        };
        task = addTask(task);
        if (typeof task === 'object') {
            $(".task-table tbody").append(
                    '<tr id="task-' + task['id'] + '">' +
                    '<td class="table-text tname"><div>' + task['name'] + '</div></td>' +
                    '<td class="table-text tdeadline"><div>' + task['deadline'] + '</div></td>' +
                    '<td class="table-text tstatus"><div>' + task['status'] + '%</div></td>' +
                    '<td class="table-text tpriority"><div>' + task['priority'] + '</div></td>' +
                    '<td>' +
                    '<button type="submit" id="delete-task-' + task['id'] + '" class="btn btn-danger delete">' +
                    '<i class="fa fa-btn fa-trash"></i>Delete' +
                    '</button>' +
                    '<button type="submit" id="edit-task-' + task['id'] + '" class="btn edit">' +
                    '<i class="fa fa-btn fa-pencil"></i> Edit' +
                    '</button>' +
                    '<button id="save-task-' + task['id'] + '" class="btn save">Save</button>' +
                    '</td>' +
                    '</tr>'
                    );
        } else {
            console.log(typeof task);
        }

    });

    window.addEventListener('load', function () {

        function updateOnlineStatus(event) {
            var status = navigator.onLine;
            if (status) {
                $(".alert-warning").hide();

                var tasks = JSON.parse(localStorage.taskRepo);

                if (localStorage.tasksToAdd) {
                    var tasksToAdd = JSON.parse(localStorage.tasksToAdd);
                    for (var i = 0; i < tasksToAdd.length; i++) {

                        $.post('/task', {'data': tasksToAdd[i]}, function (response) {

                        }).done(function (response) {
                            for (var j = tasks.length; j > 0; j--) {
                                if (tasksToAdd[i]['id'] === tasks[j]['id'])
                                    tasks[j].id = response['id'];
                            }
                        }).fail(function (xhr, textStatus, error) {
                            //console.log(xhr.statusText);
                            //console.log(textStatus);
                            //console.log(error);
                        });
                    }
                }

                for (var i = 0; i < tasks.length; i++) {
                    var task = tasks[i];
                    if (parseInt(task.id)) {
                        $.post('/edit', {'data': task}, function (response) { //excluded from csrf protection, to fix
                            //console.log(response);
                        }).fail(function (xhr, textStatus, error) {
                            //console.log(xhr.statusText);
                            //console.log(textStatus);
                            //console.log(error);
                        });
                    }
                }
                if (localStorage.tasksToDelete) {
                    var tasksToDelete = JSON.parse(localStorage.tasksToDelete);
                    for (var i = 0; i < tasksToDelete.length; i++) {
                        $.post('/delete', {'data': tasksToDelete[i]}, function (response) {

                        });
                    }
                    localStorage.tasksToDelete = "";
                }
                localStorage.tasksToAdd = "";
                localStorage.tasksToDelete = "";
                $.get('/tasks').done(function () {
                    $(".alert-success").show();
                });

            } else {
                $(".alert-warning").show();
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
    });
});
