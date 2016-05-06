


$(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});

$(document).ready(function () {

    $(".task-table").on('click', '.delete', function () {
        var id = parseInt((this.id.replace('delete-task-', '')));
        var tasks = JSON.parse(localStorage.taskRepo);
        if (localStorage.tasksToDelete) {
            var tasksToDelete = JSON.parse(localStorage.tasksToDelete);
        } else {
            var tasksToDelete = [];
        }
        for (var i = 0; i < tasks.length; i++) {
            if (tasks[i]["id"] == id) {
                if (navigator.onLine) {
                    $.post('/delete', {'data': tasks[i]["id"]}, function (response) {

                    });
                } else {
                    tasksToDelete.push(tasks[i]["id"]);
                }
                tasks.splice(i, 1);
            }
        }
        localStorage.taskRepo = JSON.stringify(tasks);
        localStorage.tasksToDelete = JSON.stringify(tasksToDelete);
        $("tr#task-" + id).remove();
    });
    $(".task-table").on('click', '.edit', function () {
        var id = parseInt((this.id.replace('edit-task-', '')));
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

        var id = parseInt((this.id.replace('save-task-', '')));
        var task = [
            id,
            $("tr#task-" + id + " .tname input").val(),
            $("tr#task-" + id + " .tdeadline input").val(),
            $("tr#task-" + id + " .tstatus select").val(),
            $("tr#task-" + id + " .tpriority select").val()
        ];
        if (navigator.onLine) {
            $.post('/edit', {'data': task}, function (response) { //excluded from csrf protection, to fix
                console.log(response);
            });
        } else {
            localStorage.setItem('taskRepo' + id, task);
        }

        $("tr#task-" + id + " .tname").html('<div>' + task[1] + '</div>');
        $("tr#task-" + id + " .tdeadline").html('<div>' + task[2] + '</div>');
        $("tr#task-" + id + " .tstatus").html('<div>' + task[3] + '%</div>');
        $("tr#task-" + id + " .tpriority").html('<div>' + task[4] + '</div>');

        $('tr#task-' + id + " .edit").show();
    });

    $(".new-task").click(function () {
        var task = {
            'name': $('#task-name').val(),
            'deadline': $('#task-deadline').val(),
            'status': $('#task-status').val(),
            'priority': $('#task-priority').val()
        };

        if (navigator.onLine) {
            $.post('/task', {'data': task}, function (response) {
            })
                    .done(function (response) {
                        console.log(response);
                        $(".task-table tbody").append(
                                '<tr id=task-' + response["id"] + '>' +
                                '<td class="table-text tname"><div>' + response['name'] + '</div></td>' +
                                '<td class="table-text tdeadline"><div>' + response['deadline'] + '</div></td>' +
                                '<td class="table-text tstatus"><div>' + response['status'] + '</div></td>' +
                                '<td class="table-text tpriority"><div>' + response['priority'] + '</div></td>' +
                                '<td>' +
                                '<button type="submit" id="delete-task-' + response["id"] + '" class="btn btn-danger delete">' +
                                '<i class="fa fa-btn fa-trash"></i>Delete' +
                                '</button>' +
                                '<button type="submit" id="edit-task-' + response["id"] + '" class="btn edit">' +
                                '<i class="fa fa-btn fa-pencil"></i> Edit' +
                                '</button>' +
                                '<button id="save-task-' + response["id"] + '" class="btn save">Save</button>' +
                                '</td>' +
                                "</tr>"
                                );
                        var tasks = JSON.parse(localStorage.taskRepo);
                        task.id = response['id'];
                        tasks.push(task);
                        localStorage.taskRepo = JSON.stringify(tasks);
                    });
        } else {
            if (localStorage.tasksToAdd) {
                var tasksToAdd = JSON.parse(localStorage.tasksToAdd);
            } else {
                var tasksToAdd = [];
            }
            tasksToAdd.push(task);
            localStorage.tasksToAdd = JSON.stringify(tasksToAdd);
        }
    });

    window.addEventListener('load', function () {

        function updateOnlineStatus(event) {
            var status = navigator.onLine;
            if (status) {
                $(".alert-success").show();
                var tasks = JSON.parse(localStorage.taskRepo);
                if (localStorage.tasksToDelete) {
                    var tasksToDelete = JSON.parse(localStorage.tasksToDelete);
                    for (var i = 0; i < tasksToDelete.length; i++) {
                        $.post('/delete', {'data': tasksToDelete[i]}, function (response) {

                        });
                    }
                    localStorage.tasksToDelete = "";
                }
                if (localStorage.tasksToAdd) {
                    var tasksToAdd = JSON.parse(localStorage.tasksToAdd);
                    for (var i = 0; i < tasksToAdd.length; i++) {
                        $.post('/task', {'data': tasksToAdd[i]}, function (response) {

                        });
                    }
                    localStorage.tasksToAdd = "";
                }

                for (var i = 0; i < tasks.length; i++) {
                    var task = tasks[i];
                    $.post('/edit', {'data': task}, function (response) { //excluded from csrf protection, to fix
                        console.log(response);
                    });
                }


                localStorage.tasksToDelete = "";
            } else {
                $(".alert-warning").show();
            }
        }

        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
    });
});
