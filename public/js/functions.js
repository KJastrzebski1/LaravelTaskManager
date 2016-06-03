
function addTask(task) {
    if(localStorage.taskRepo){
        var tasks = JSON.parse(localStorage.taskRepo);
    }else{
        var tasks = [];
    }
    
    var tasksToAdd = [];
    return new Promise(function (resolve, reject) {
        if (navigator.onLine) {
            $.ajax({
                'url': '/task',
                'method': 'post',
                'data': {'data': task},
                'async': true,
                'success': function (response) {
                    
                    task = response['task'];
                    tasks.push(task);
                    localStorage.taskRepo = JSON.stringify(tasks);
                    resolve(task);
                }
            });
        } else {
            if (localStorage.tasksToAdd) {
                tasksToAdd = JSON.parse(localStorage.tasksToAdd);
            } else {
                tasksToAdd = [];
            }
            task['id'] = 'tmp-' + tasksToAdd.length;
            task['user_id'] = 0;
            tasksToAdd.push(task);
            tasks.push(task);
            localStorage.tasksToAdd = JSON.stringify(tasksToAdd);
            localStorage.taskRepo = JSON.stringify(tasks);
            resolve(task);
        }
    });
    //return task;

}
function getUsers(org_id) {
    var users = [];
    $.ajax({
        'url': '/users/'+org_id,
        'method': 'get',
        'async': false,
        'error': function (response) {
            task = 'Error';
        },
        'success': function (response) {
            users = response;
        }
    });
    return users;
}
function editTask(task) {
    var id = task.id;
    var tasks = JSON.parse(localStorage.taskRepo);
    var tasksToAdd = [];
    if (localStorage.tasksToAdd) {
        tasksToAdd = JSON.parse(localStorage.tasksToAdd);
    }
    if (navigator.onLine) {
        $.ajax({
            'url': '/edit',
            'method': 'post',
            'data': {'data': task},
            'async': false,
            'error': function (response) {
                task = 'Error';
            }
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
                $.ajax({
                    'url': '/delete',
                    'method': 'post',
                    'data': {'data': tasks[i]['id']},
                    'async': false,
                    'success': function () {
                        response = "deleted";
                    }
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

function addProject(project) {
    console.log(project);
    if (navigator.onLine) {
        $.ajax({
            'url': '/project',
            'method': 'post',
            'data': {'data': project},
            'async': false,
            'success': function () {
            }
        });
    }
}