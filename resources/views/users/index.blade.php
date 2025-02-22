@extends('base')

@section('title', 'Gestion des Utilisateurs')

@section('content')

<div class="container mt-5">
    <h1>Gestion des Utilisateurs</h1>

    @if(auth()->user()->can('update User'))
        {{-- Scan QR Code Button --}}
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#qrScannerModal">
            <i class="fas fa-qrcode"></i> Scanner un QR Code
        </button>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou email" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </div>
    </form>

    @if(auth()->user()->can('create User'))
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>
    @endif

    @if(auth()->user()->hasRole('admin'))
        <!-- Table des utilisateurs pour les admins -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Institution</th>
                    <th>Adresse</th>
                    <th>État</th>
                    <th>Pays</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->institution ?? 'N/A' }}</td>
                        <td>{{ $user->address ?? 'N/A' }}</td>
                        <td>{{ $user->state }}</td>
                        <td>{{ $user->country }}</td>
                        <td>
                            @if(auth()->user()->can('update User'))
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            @endif

                            @if(auth()->user()->can('delete User'))
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                    Supprimer
                                </button>

                                <!-- Modal de confirmation -->
                                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteUserLabel">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Voulez-vous vraiment supprimer l'utilisateur "{{ $user->full_name }}" ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- Vue en cartes pour les visiteurs et modérateurs -->
        <div class="row">
            @foreach ($users as $user)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->full_name }}</h5>
                            <p class="card-text"><strong>Email :</strong> {{ $user->email }}</p>
                            <p class="card-text"><strong>Institution :</strong> {{ $user->institution ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Pays :</strong> {{ $user->country }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->appends(['search' => request()->query('search')])->links() }}
    </div>
</div>

{{-- QR Scanner Modal --}}
<div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrScannerModalLabel">Scanner un QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <video id="qr-video" width="100%"></video>
                <p id="qr-result" class="mt-3 text-success fw-bold"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- QR Code Scanner Script --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.3.2/jsQR.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let video = document.getElementById("qr-video");
        let resultDisplay = document.getElementById("qr-result");
        let scanning = false;

        async function startQRScanner() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    let stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
                    video.srcObject = stream;
                    video.setAttribute("playsinline", true);
                    video.play();
                    scanQRCode();
                } catch (error) {
                    console.error("Erreur accès caméra :", error);
                }
            }
        }

        function scanQRCode() {
            let canvas = document.createElement("canvas");
            let context = canvas.getContext("2d");

            setInterval(() => {
                if (!scanning && video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    let imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    let code = jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: "dontInvert" });

                    if (code) {
                        scanning = true;
                        resultDisplay.textContent = "QR Code détecté : " + code.data;
                        window.location.href = "/verify-qr/" + code.data;
                    }
                }
            }, 500);
        }

        document.querySelector('[data-bs-target="#qrScannerModal"]').addEventListener("click", startQRScanner);
    });
</script>

@endsection
