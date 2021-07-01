<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Cliente Id</th>
      <th scope="col">Pais</th>
      <th scope="col">Ciudad</th>
      <th scope="col">Fecha del Viaje</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($dataviewtable as $dataview => $key)
        <tr>
          <th scope="row">{{ $key['id'] }}</th>
          <td>{{ $key['client_id'] }}</td>
          <td>{{ $key['country'] }}</td>
          <td>{{ $key['city'] }}</td>
          <td>{{ $key['created_at'] }}</td>
        </tr>
    @endforeach
    @empty($dataviewtable)
      <h4 class="text-danger">No ha realizado viajes</h4>
    @endempty
  </tbody>
  <tfoot>
    <tr>
      <th class="text-center" colspan="5">
        <a href="{{ url('/') }}">
          <button type="button" class="btn btn-primary"> Atras </button>
        </a>
      </th>
    </tr>
  </tfoot>
</table>