<html>
    <head>
        <meta charset="utf-8">
        <title>Routing Test</title>

        <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-1.23.1.css">
        <script src="https://code.jquery.com/qunit/qunit-1.23.1.js"></script>
        <script>
            // Add Task Tests
            QUnit.test("Testing task manipulation", function (assert) {
                var task = {
                    'name': 'test',
                    'deadline': '2016-05-12',
                    'status': '10',
                    'priority': 'Low'
                };
                var newTask;
                
                assert.equal(newTask = addTask(task), task);
                
                assert.equal(editTask(newTask), newTask);
               
                assert.equal(deleteTask(newTask), null);
                assert.equal(deleteTask(newTask["id"]), "deleted");
            });
        </script>
    </head>
    <body>
        <div id="qunit"></div>

    </body>
    <footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
    </footer>

</html>