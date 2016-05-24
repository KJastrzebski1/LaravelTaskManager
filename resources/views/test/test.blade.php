<html>
    <head>
        <meta charset="utf-8">
        <title>Routing Test</title>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-1.23.1.css">
        <script src="https://code.jquery.com/qunit/qunit-1.23.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
    </head>
    <body>
        <script>
            // Add Task Tests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            QUnit.test("Testing task manipulation", function (assert) {
                var task = {
                    'name': 'test',
                    'deadline': '2016-05-12',
                    'status': '10',
                    'priority': 'Low',
                    'project_id': 0,
                    'user_id': {{ Auth::user()->id }}
                };
                var newTask;
                newTask = addTask(task);
                assert.notEqual(newTask['id'], null);
                console.log(newTask['id']);
                assert.equal(editTask(newTask), newTask);

                assert.equal(deleteTask(newTask), null);
                assert.equal(deleteTask(newTask["id"]), "deleted");
            });
        </script>
        <div id="qunit"></div>
        <?php //var_dump(Auth::user()); ?>
    </body>
    <footer>
        
    </footer>

</html>