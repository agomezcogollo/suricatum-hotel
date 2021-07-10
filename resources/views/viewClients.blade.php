<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Telefono</th>
      <th scope="col">Correo</th>
      <th scope="col">Dirección</th>
      <th scope="col">foto</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($dataviewtable as $dataview => $key)
        <tr>
          <th scope="row">{{ $key['id'] }}</th>
          <td>{{ $key['name'] }}</td>
          <td>{{ $key['surname'] }}</td>
          <td>{{ $key['phone'] }}</td>
          <td>{{ $key['email'] }}</td>
          <td>{{ $key['address'] }}</td>
          <td><a href="{{ url($key['photo']) }}" target="_blank">Ver</a></td>
          <td>
              <a href="{{ route('travels', [ 'idsearch' => $key['id'] ]) }}">
                  <button type="button" class="btn btn-primary"> Ver Viajes </button>
              </a>
              <form action="deleteClients" method="POST">
                @csrf
                <input type="hidden" name="idDelete" value="{{ $key['id'] }}">
                <button type="submit" class="btn btn-danger" style="width: 96px;"> Eliminar </button>
              </form>
          </td>
        </tr>
    @endforeach
  </tbody>
</table>