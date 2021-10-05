@if (auth()->user()->isAdmin())
    <li class="list-group-item">
        <a href="{{ route('admin.departments.index') }}">Departments</a>
    </li>
    <li class="list-group-item">
        <a href="{{route('admin.employees.index')}}">Employees</a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('admin.tasks.index') }}">Tasks</a>
    </li>
@elseif(auth()->user()->isEmployee())
    <li class="list-group-item">
        <a href="{{ route('admin.employees.assigned_tasks') }}">Assigned Tasks</a>
    </li>

@endif
