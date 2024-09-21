@extends('mm.templates.index')

@section('page-dashboard')
    <div class="container mx-auto px-8 py-6">
        <div class="grid grid-cols-1 gap-8">

            <!-- Data Harian Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto w-full">
                <h2 class="text-3xl font-semibold mb-6 text-blue-800 border-b-4 border-blue-400 pb-2">Data Harian
                    {{ $title }}</h2>

                @if ($harianData->isEmpty())
                    <p class="text-gray-600 text-lg">Tidak ada data yang tersedia.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                                <tr>
                                    @foreach (['No.', 'Nama Marketing', 'Tanggal', 'Project', 'Pekerjaan', 'Alamat', 'Status', 'Actions'] as $header)
                                        <th class="py-3 px-4 text-left border-b">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm divide-y divide-gray-300">
                                @foreach ($harianData as $index => $data)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4">{{ $data->marketing->name }}</td>
                                        <td class="py-3 px-4">{{ $data->date }}</td>
                                        <td class="py-3 px-4">{{ $data->project }}</td>
                                        <td class="py-3 px-4">{{ $data->pekerjaan }}</td>
                                        <td class="py-3 px-4">{{ $data->alamat }}</td>
                                        <td class="py-3 px-4">{{ $data->prospek }}</td>
                                        <td class="py-3 px-4 flex space-x-1">
                                            <form
                                                action="{{ route('harian.approve', ['id' => Crypt::encrypt($data->id)]) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit"
                                                    class="px-2 py-1 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">Setuju</button>
                                            </form>
                                            <form
                                                action="{{ route('harian.reject', ['id' => Crypt::encrypt($data->id)]) }}"
                                                method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit"
                                                    class="px-2 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateHiddenInputs() {
                    var selectedProject = document.getElementById('projectDropdown') ? document.getElementById(
                        'projectDropdown').value : '';
                    document.getElementById('projectExcel').value = selectedProject;
                    document.getElementById('projectPDF').value = selectedProject;
                }

                document.getElementById('projectDropdown')?.addEventListener('change', updateHiddenInputs);
                document.getElementById('excelExportForm').addEventListener('submit', updateHiddenInputs);
                document.getElementById('pdfExportForm').addEventListener('submit', updateHiddenInputs);
            });
        </script>
    @endsection
