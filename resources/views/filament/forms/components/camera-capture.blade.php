<div x-data="{
    stream: null,
    captured: false,
    initCamera() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
            .then(s => {
                this.stream = s;
                $refs.video.srcObject = s;
            })
            .catch(err => alert('Kamera tidak akses: ' + err));
    },
    takeSnap() {
        const canvas = document.createElement('canvas');
        canvas.width = $refs.video.videoWidth;
        canvas.height = $refs.video.videoHeight;
        canvas.getContext('2d').drawImage($refs.video, 0, 0);
        const data = canvas.toDataURL('image/png');
        $wire.set('{{ $getStatePath() }}', data);
        this.captured = true;
        this.stopCamera();
    },
    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
        }
    }
}" x-init="initCamera()" class="relative border rounded-2xl overflow-hidden bg-black">
    
    <video x-ref="video" autoplay playsinline class="w-full h-auto" x-show="!captured"></video>
    
    <template x-if="captured">
        <div class="p-4 text-center bg-green-100 text-green-700 font-bold">
            ✅ Foto Berhasil Diambil!
        </div>
    </template>

    <div class="p-4 bg-gray-900 flex justify-center" x-show="!captured">
        <button type="button" @click="takeSnap()" class="bg-white text-black px-6 py-2 rounded-full font-bold shadow-lg hover:bg-gray-200 transition">
            📸 Ambil Foto Sekarang
        </button>
    </div>
</div>