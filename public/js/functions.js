function addTask(task) {
    var tasks = JSON.parse(localStorage.taskRepo);
    var tasksToAdd = [];
    if (navigator.onLine) {
        $.post('/task', {'data': task}, function (response) {
        })
                .done(function (response) {
                    task.id = response['id'];
                    tasks.push(task);
                    localStorage.taskRepo = JSON.stringify(tasks);
                })
                .fail(function (response) {
                    task = response;
                });
    } else {
        if (localStorage.tasksToAdd) {
            tasksToAdd = JSON.parse(localStorage.tasksToAdd);
        } else {
            tasksToAdd = [];
        }
        task["id"] = 'tmp-' + tasksToAdd.length;

        tasksToAdd.push(task);
        tasks.push(task);
        localStorage.tasksToAdd = JSON.stringify(tasksToAdd);
        localStorage.taskRepo = JSON.stringify(tasks);

    }
    return task;
}

function editTask(task) {
    var id = task.id;
    var tasks = JSON.parse(localStorage.taskRepo);
    var tasksToAdd = [];
    if (localStorage.tasksToAdd) {
        tasksToAdd = JSON.parse(localStorage.tasksToAdd);
    }
    if (navigator.onLine) {
        $.post('/edit', {'data': task}, function (response) { //excluded from csrf protection, to fix
            //console.log(response);
        });
    } else {

        if (parseInt(id)) {
            for (var i = 0; i < tasks.length; i++) {
                if (id == tasks[i]['id']) {
                    tasks[i] = task;
                }
            }
        } else {

            for (var i = 0; i < tasksToAdd.length; i++) {
                if (id == tasksToAdd[i]['id']) {
                    tasksToAdd[i] = task;
                }
            }
        }
        localStorage.tasksToAdd = JSON.stringify(tasksToAdd);
    }
    localStorage.taskRepo = JSON.stringify(tasks);
    return task;
}
function deleteTask(id) {
    var tasks = JSON.parse(localStorage.taskRepo);
    var tasksToAdd = [];
    var response = null;
    if (localStorage.tasksToAdd) {
        tasksToAdd = JSON.parse(localStorage.tasksToAdd);
    }
    if (localStorage.tasksToDelete) {
        var tasksToDelete = JSON.parse(localStorage.tasksToDelete);
    } else {
        var tasksToDelete = [];
    }
    for (var i = 0; i < tasks.length; i++) {
        if (tasks[i]["id"] == id) {
            if (navigator.onLine) {
                $.post('/delete', {'data': tasks[i]["id"]}, function () {
                    
                }).done(function(){
                    response = "deleted";
                });
            } else {
                var status = 1;
                for (var j = 0; j < tasksToAdd.length; j++) {
                    if (tasksToAdd[j]['id'] === id) {
                        tasksToAdd.splice(j, 1);
                        status = 0;
                    }
                }
                if (status) {
                    tasksToDelete.push(tasks[i]["id"]);
                }
            }
            tasks.splice(i, 1);
        }
    }
    localStorage.tasksToAdd = JSON.stringify(tasksToAdd);
    localStorage.taskRepo = JSON.stringify(tasks);
    localStorage.tasksToDelete = JSON.stringify(tasksToDelete);

    return response;
}

