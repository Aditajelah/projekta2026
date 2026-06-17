<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6f9fc 0%, #ebf3ff 100%);
            color: #1f2937;
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 920px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #dbe7ff;
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 18px 40px rgba(22, 63, 130, 0.08);
        }

        h1 {
            font-size: 30px;
            margin-bottom: 8px;
            color: #1f3b7a;
        }

        .subtitle {
            color: #4b5563;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .contact-box {
            background: #eef5ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .contact-box strong {
            display: block;
            margin-bottom: 10px;
        }

        .email-box {
            display: inline-block;
            background: #fff;
            border: 1px dashed #9db9ea;
            border-radius: 8px;
            padding: 10px 12px;
            font-weight: 600;
            color: #1f3b7a;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 12px;
            color: #1f3b7a;
        }

        .faq-list {
            display: grid;
            gap: 12px;
            margin-bottom: 18px;
        }

        details {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            background: #fff;
        }

        summary {
            cursor: pointer;
            font-weight: 600;
            color: #1f2937;
        }

        details p {
            margin-top: 10px;
            color: #4b5563;
            line-height: 1.6;
        }

        .note {
            background: #fff7ed;
            border: 1px solid #fdba74;
            color: #9a3412;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .back-link {
            margin-top: 6px;
            display: inline-block;
            color: #1f3b7a;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            h1 {
                font-size: 24px;
            }

            h2 {
                font-size: 19px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Customer Service</h1>
        <p class="subtitle">
            Halaman ini disediakan untuk membantu member yang mengalami kendala akun, termasuk akun yang dinonaktifkan.
        </p>

        <section class="contact-box">
            <strong>Kontak resmi Customer Service:</strong>
            <div class="email-box">adityokaylanfiros@gmail.com</div>
        </section>

        <h2>Pertanyaan yang Sering Ditanyakan</h2>
        <div class="faq-list">
            <details>
                <summary>Kenapa akun saya dinonaktifkan?</summary>
                <p>
                    Akun dapat dinonaktifkan oleh admin jika ditemukan pelanggaran kebijakan platform atau aktivitas yang perlu diverifikasi lebih lanjut.
                </p>
            </details>

            <details>
                <summary>Bagaimana cara mengaktifkan akun saya kembali?</summary>
                <p>
                    Kirim email ke Customer Service dengan subjek "Permohonan Aktivasi Ulang Akun", lalu sertakan email akun Anda dan penjelasan singkat kendala.
                </p>
            </details>

            <details>
                <summary>Berapa lama proses verifikasi aktivasi ulang?</summary>
                <p>
                    Estimasi proses verifikasi adalah 1 sampai 3 hari kerja, tergantung antrean dan kelengkapan data yang Anda kirimkan.
                </p>
            </details>

            <details>
                <summary>Data apa yang perlu saya kirim saat menghubungi CS?</summary>
                <p>
                    Minimal sertakan email akun, username, waktu terakhir bisa login, dan ringkasan masalah. Data ini mempercepat proses pengecekan.
                </p>
            </details>
        </div>

        <div class="note">
            Untuk keamanan, jangan kirim password melalui email. Tim Customer Service tidak akan pernah meminta password Anda.
        </div>

        <a class="back-link" href="{{ route('login') }}">Kembali ke halaman login</a>
    </main>
</body>
</html>
