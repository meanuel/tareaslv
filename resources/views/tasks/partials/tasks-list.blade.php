@if(!empty($tasks))
    <section class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">Task</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>.....</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endif