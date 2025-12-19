<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #ff6b6b 100%);
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-header {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.3), rgba(238, 90, 36, 0.3));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-total {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.3), rgba(39, 174, 96, 0.3));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .dot-pattern {
            background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .perforated-edge {
            position: relative;
            overflow: hidden;
        }

        .perforated-edge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: repeating-linear-gradient(
                90deg,
                transparent 0px,
                transparent 8px,
                rgba(255,255,255,0.1) 8px,
                rgba(255,255,255,0.1) 12px
            );
        }

        .ticket-shadow {
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .qr-glow {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute inset-0 dot-pattern opacity-20"></div>
    <button onclick="window.print()" class="fixed top-6 right-6 glass-effect text-white px-6 py-3 rounded-full font-semibold hover:bg-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-lg z-10">
        🖨️ Print Ticket
    </button>

    <div class="ticket-container max-w-sm w-full relative z-10">
        <div class="glass-effect rounded-2xl overflow-hidden ticket-shadow transform hover:scale-105 transition-all duration-500">

            <div class="glass-header text-white p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <h1 class="text-3xl font-bold mb-2 relative z-10 bg-gradient-to-r from-white to-pink-200 bg-clip-text text-transparent">TJINEMA</h1>
                <p class="text-sm opacity-90 relative z-10">Your Premium Cinema Experience</p>
                <div class="absolute -top-10 -right-10 w-20 h-20 bg-white/10 rounded-full animate-pulse-slow"></div>
                <div class="absolute -bottom-5 -left-5 w-16 h-16 bg-white/5 rounded-full animate-float"></div>
            </div>

            <div class="perforated-edge h-4 bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

            <div class="p-6 space-y-4">
                <div class="glass-effect rounded-xl p-4 hover:bg-white/15 transition-all duration-300">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-white/70 text-sm font-medium">Movie:</span>
                        <span class="text-pink-400 font-bold text-right max-w-48 truncate">Inception</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-white/70">Date:</span>
                            <span class="text-white font-medium">1 Jul 2025</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/70">Time:</span>
                            <span class="text-white font-medium">19:12 - 21:40</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-white/10">
                        <span class="text-white/70 text-sm">Theater:</span>
                        <span class="text-white font-medium">Theater 1</span>
                    </div>
                </div>

                <div class="glass-effect rounded-xl p-4 hover:bg-white/15 transition-all duration-300">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-white/70 text-sm font-medium">Seats:</span>
                        <div class="bg-gradient-to-r from-pink-500/20 to-purple-500/20 px-4 py-2 rounded-lg border border-pink-400/30">
                            <span class="text-pink-400 font-bold">A1, A2, A3</span>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-xl p-4 hover:bg-white/15 transition-all duration-300">
                </div>
            </div>

            <div class="glass-total text-white p-6 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
                <div class="relative z-10">
                    <p class="text-sm opacity-90 mb-1">Total Amount</p>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-white to-green-200 bg-clip-text text-transparent">Rp 205,000</h2>
                </div>
                <div class="absolute -top-5 -right-5 w-16 h-16 bg-white/5 rounded-full animate-pulse-slow"></div>
            </div>

            <div class="glass-effect p-6 text-center border-t border-white/10">
                <div class="qr-glow w-20 h-20 mx-auto mb-4 bg-white rounded-xl flex items-center justify-center" id="qrcode"></div>
                <div class="text-white/90 font-bold text-sm tracking-wider mb-3">BOOKING #TJ2025063001</div>
                <div class="text-white/60 text-xs leading-relaxed">
                    Please arrive 15 minutes before showtime.<br>
                    Present this ticket at the theater entrance.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            gsap.from(".ticket-container", {
                duration: 1,
                y: 50,
                opacity: 0,
                ease: "power3.out"
            });

            gsap.from(".glass-effect", {
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.1,
                ease: "power2.out",
                delay: 0.3
            });

            const bookingNumber = 'TJ2025063001';
            const qrData = `TJINEMA-BOOKING:${bookingNumber}`;

            QRCode.toCanvas(document.getElementById('qrcode'), qrData, {
                width: 76,
                height: 76,
                margin: 1,
                color: {
                    dark: '#333333',
                    light: '#FFFFFF'
                }
            }, function (error) {
                if (error) {
                    console.error('QR Code generation failed:', error);
                    document.getElementById('qrcode').innerHTML = '<div class="text-xs text-gray-500">QR CODE</div>';
                }
            });
        });
    </script>
</body>
</html>
