


$(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
        if (permission) {
            var loc = location.pathname.split("/");
            var org_id = parseInt(loc[loc.length - 1]);
            var users = getUsers(org_id);
            var user = '<select class="form-control">';
            for (var i = 0; i < users.length; i++) {
                user += '<option value=' + users[i].id + '>' + users[i].name + '</option>';
            }
            user += '</select>';
            $("tr#task-" + id + " .tuser").html(user);
            $("tr#task-" + id + " .tuser select").val(task["user_id"]);
        }

    });

    $(".task-table").on('click', '.save', function () {
        $(this).hide();

        var id = (this.id.replace('save-task-', ''));
        var loc = location.pathname.split("/");
        var org_id = parseInt(loc[loc.length - 1]);
        var task = {
            'id': id,
            'name': $("tr#task-" + id + " .tname input").val(),
            'deadline': $("tr#task-" + id + " .tdeadline input").val(),
            'status': $("tr#task-" + id + " .tstatus select").val(),
            'priority': $("tr#task-" + id + " .tpriority select").val(),
            'org_id': org_id
        };
        if (permission) {
            task.user_id = $("tr#task-" + id + " .tuser select").val();
            var user_name = $("tr#task-" + id + " .tuser select option:selected").text();
        }

        task = editTask(task);
        if (typeof task === 'object') {
            id = task.id;
            $("tr#task-" + id + " .tname").html('<div>' + task['name'] + '</div>');
            $("tr#task-" + id + " .tdeadline").html('<div>' + task['deadline'] + '</div>');
            $("tr#task-" + id + " .tstatus").html('<div>' + task['status'] + '%</div>');
            $("tr#task-" + id + " .tpriority").html('<div>' + task['priority'] + '</div>');
            if (permission) {
                $("tr#task-" + id + " .tuser").html('<div>' + user_name + '</div>');
            }
            $('tr#task-' + id + " .edit").show();
        } else {
            console.log(task);
        }

    });

    $(".new-task").click(function () {
        var task = {
            'name': $('#task-name').val(),
            'deadline': $('#task-deadline').val(),
            'status': $('#task-status').val(),
            'priority': $('#task-priority').val(),
            'project_id': parseInt($('#task-project').val())
        };
        //task = addTask(task);
        console.log('elo');
        addTask(task).then(function (response) {
            if (typeof response === 'object')
            {
                var users = getUsers();
                console.log(response);
                $("#project-" + response['project_id'] + " .task-table tbody").append(
                        '<tr id="task-' + response['id'] + '">' +
                        '<td class="table-text tname"><div>' + response['name'] + '</div></td>' +
                        '<td class="table-text tdeadline"><div>' + response['deadline'] + '</div></td>' +
                        '<td class="table-text tstatus"><div>' + response['status'] + '%</div></td>' +
                        '<td class="table-text tpriority"><div>' + response['priority'] + '</div></td>' +
                        '<td class="table-text tuser"><div>' + users[response.user_id.id].name + '</div></td>' +
                        '<td>' +
                        '<button type="submit" id="delete-task-' + response['id'] + '" class="btn btn-danger delete">' +
                        '<i class="fa fa-btn fa-trash"></i>Delete' +
                        '</button>' +
                        '<button type="submit" id="edit-task-' + response['id'] + '" class="btn edit">' +
                        '<i class="fa fa-btn fa-pencil"></i> Edit' +
                        '</button>' +
                        '<button id="save-task-' + response['id'] + '" class="btn save">Save</button>' +
                        '</td>' +
                        '</tr>'
                        );
            } else {
                console.log(typeof response);
            }
        });
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

                        addTask(tasksToAdd[i]).then(function (response) {
                            for (var j = tasks.length; j > 0; j--) {
                                if (tasksToAdd[i]['id'] === tasks[j]['id'])
                                    tasks[j].id = response['id'];
                            }
                        });
                    }
                }

                for (var i = 0; i < tasks.length; i++) {
                    var task = tasks[i];
                    if (parseInt(task.id)) {
                        editTask(task);
                    }
                }
                if (localStorage.tasksToDelete) {
                    var tasksToDelete = JSON.parse(localStorage.tasksToDelete);
                    for (var i = 0; i < tasksToDelete.length; i++) {

                        deleteTask(tasksToDelete[i]);
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

    $('.members-table').on('click', '.set-role', function () {
        var $btn = $(this).html("Save");
        $btn.toggleClass("set-role");
        $btn.toggleClass("save-role");

        var id = parseInt(this.id.replace('set-role-', ''));
        var loc = location.pathname.split("/");
        var org_id = parseInt(loc[loc.length - 1]);
        var roles;
        getRoles(org_id).then(function (response) {
            roles = response;

            console.log(roles);
            var select = "<select>";
            for (var i = 0; i < roles.length; i++) {
                select += "<option value=" + roles[i].id + ">" + roles[i].name + "</option>";
            }
            select += "</select>";
            $("#member-" + id + " .member-role").html(select);


        });
    });
    $('.members-table').on('click', '.save-role', function () {
        var $btn = $(this).html("Edit");
        $btn.toggleClass("set-role");
        $btn.toggleClass("save-role");
        var id = parseInt(this.id.replace('set-role-', ''));
        var role_id = $('#member-' + id + ' .member-role option:selected').val();
        var role_name = $('#member-' + id + ' .member-role option:selected').html();
        var org_id = parseInt(location.pathname.replace('/organization/', ''));
        setRole(id, org_id, role_id).then(function (response) {
            $("#member-" + id + " .member-role").html(role_name);
        });
    });
});
