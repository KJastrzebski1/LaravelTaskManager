
<tr id='task-{{ $task->id }}'>
    <td class="table-text tname"><div>{{ $task->name }}</div></td>
    <td class="table-text tdeadline"><div>{{ $task->deadline }}</div></td>
    <td class="table-text tstatus"><div>{{ $task->status}}%</div></td>
    <td class="table-text tpriority"><div>{{ $task->priority}}</div></td>
    <td class='table-text tuser'><div>{{ $users[$task->user_id]->name }}</div></td>
    <!-- Task Delete Button -->
    <td>
        <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger delete">
            <i class="fa fa-btn fa-trash"></i>Delete
        </button>
        <button type="submit" id="edit-task-{{ $task->id }}" class="btn edit">
            <i class="fa fa-btn fa-pencil"></i> Edit
        </button>
        <button id="save-task-{{ $task->id }}" class="btn save">Save</button>
    </td>
</tr>
