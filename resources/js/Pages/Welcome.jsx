import React, { useState } from "react";
import { Head, useForm } from "@inertiajs/react";

export default function Welcome({ auth, landingData }) {
    // State Form Guest (Tanpa customer_phone)
    const { data, setData, post, processing, reset } = useForm({
        date: "",
        session: "pagi",
        customer_name: auth.user ? auth.user.name : "",
    });

    const [successMsg, setSuccessMsg] = useState(null);

    // Fungsi Submit ke Backend
    const handleSubmit = (e) => {
        e.preventDefault();

        post("/booking", {
            onSuccess: (page) => {
                // Ambil pesan sukses dari Controller (Flash Message)
                const msg =
                    page.props.flash?.success ||
                    `Halo ${data.customer_name}, pendaftaran berhasil!`;
                setSuccessMsg(msg);
                reset(); // Bersihkan form

                // Hilangkan pesan setelah 10 detik
                setTimeout(() => setSuccessMsg(null), 10000);
            },
            onError: (errors) => {
                console.log("Gagal daftar:", errors);
            },
        });
    };

    const scrollToSection = (id) => {
        const element = document.getElementById(id);
        if (element) element.scrollIntoView({ behavior: "smooth" });
    };

    return (
        <>
            <Head title="Pemancingan Empang" />

            <div className="min-h-screen bg-gray-50 text-gray-800 font-sans">
                {/* NAVBAR */}
                <nav className="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center">
                                <span className="text-2xl font-bold text-blue-600">
                                    🎣 EmpangMantap
                                </span>
                            </div>
                            <div className="hidden md:flex space-x-8">
                                <button
                                    onClick={() => scrollToSection("home")}
                                    className="hover:text-blue-600"
                                >
                                    Beranda
                                </button>
                                <button
                                    onClick={() => scrollToSection("about")}
                                    className="hover:text-blue-600"
                                >
                                    Tentang
                                </button>
                                <button
                                    onClick={() => scrollToSection("gallery")}
                                    className="hover:text-blue-600"
                                >
                                    Galeri
                                </button>
                                <button
                                    onClick={() => scrollToSection("booking")}
                                    className="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 font-bold"
                                >
                                    Daftar Lomba
                                </button>
                            </div>
                            <div className="md:hidden">
                                <a
                                    href="/login"
                                    className="text-sm text-gray-500"
                                >
                                    Login Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                {/* HERO SECTION */}
                <section
                    id="home"
                    className="relative pt-32 pb-24 bg-blue-900 overflow-hidden"
                >
                    <div className="absolute inset-0 opacity-30">
                        <img
                            src="https://images.unsplash.com/photo-1544551763-46a873d57286?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                            alt="Background"
                            className="w-full h-full object-cover"
                        />
                    </div>
                    <div className="relative max-w-7xl mx-auto px-4 text-center text-white">
                        <h1 className="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
                            Rasakan Sensasi Strike <br />{" "}
                            <span className="text-blue-400">
                                Di Empang Terbaik
                            </span>
                        </h1>
                        <p className="mt-4 max-w-2xl mx-auto text-xl text-gray-300">
                            Air jernih, ikan melimpah, dan fasilitas lengkap.
                        </p>

                        <div className="mt-10 grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl mx-auto">
                            <div className="bg-white/10 backdrop-blur border border-white/20 p-6 rounded-xl">
                                <div className="text-blue-300 font-bold uppercase text-sm">
                                    Jam Operasional
                                </div>
                                <div className="text-2xl font-bold">
                                    {landingData.jam_buka}
                                </div>
                            </div>
                            <div className="bg-white/10 backdrop-blur border border-white/20 p-6 rounded-xl">
                                <div className="text-green-300 font-bold uppercase text-sm">
                                    Tiket Lomba
                                </div>
                                <div className="text-2xl font-bold">
                                    Rp{" "}
                                    {Number(
                                        landingData.harga_tiket
                                    ).toLocaleString("id-ID")}{" "}
                                    / Lapak
                                </div>
                            </div>
                        </div>

                        <div className="mt-10">
                            <button
                                onClick={() => scrollToSection("booking")}
                                className="px-8 py-4 bg-yellow-500 text-black font-bold rounded-full text-lg hover:bg-yellow-400 shadow-lg transform hover:scale-105 transition"
                            >
                                BOOKING SEKARANG 🚀
                            </button>
                        </div>
                    </div>
                </section>

                {/* TENTANG KAMI */}
                <section id="about" className="py-16 bg-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                            <div>
                                <img
                                    src="https://images.unsplash.com/photo-1596450517418-c8650d2df2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                    alt="Tentang Empang"
                                    className="rounded-2xl shadow-2xl rotate-2"
                                />
                            </div>
                            <div>
                                <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                    Tentang Pemancingan Kami
                                </h2>
                                <p className="text-lg text-gray-600 mb-6 whitespace-pre-line">
                                    {landingData.about_us}
                                </p>
                                <ul className="space-y-3">
                                    <li className="flex items-center text-gray-700">
                                        ✅ Air sirkulasi jalan terus
                                    </li>
                                    <li className="flex items-center text-gray-700">
                                        ✅ Kantin & Kopi 24 jam
                                    </li>
                                    <li className="flex items-center text-gray-700">
                                        ✅ Mushola & Toilet bersih
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                {/* GALERI */}
                <section id="gallery" className="py-16 bg-gray-50">
                    <div className="max-w-7xl mx-auto px-4 text-center mb-12">
                        <h2 className="text-3xl font-bold text-gray-900">
                            Galeri Seru
                        </h2>
                        <p className="text-gray-500">
                            Dokumentasi kegiatan lomba dan harian.
                        </p>
                    </div>
                    <div className="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        {landingData.galleries.length === 0
                            ? [1, 2, 3, 4].map((item) => (
                                  <div
                                      key={item}
                                      className="relative group overflow-hidden rounded-xl shadow-lg h-64"
                                  >
                                      <img
                                          src={`https://picsum.photos/400/300?random=${item}`}
                                          className="w-full h-full object-cover grayscale opacity-50"
                                      />
                                      <div className="absolute inset-0 flex items-center justify-center">
                                          <span className="text-white font-bold bg-black/50 px-2 py-1 rounded">
                                              Belum ada foto
                                          </span>
                                      </div>
                                  </div>
                              ))
                            : landingData.galleries.map((item) => (
                                  <div
                                      key={item.id}
                                      className="relative group overflow-hidden rounded-xl shadow-lg h-64"
                                  >
                                      <img
                                          src={`/storage/${item.image}`}
                                          alt="Galeri"
                                          className="w-full h-full object-cover transform group-hover:scale-110 transition duration-500"
                                      />
                                      {item.caption && (
                                          <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                              <span className="text-white font-bold px-2 text-center">
                                                  {item.caption}
                                              </span>
                                          </div>
                                      )}
                                  </div>
                              ))}
                    </div>
                </section>

                {/* FORM BOOKING (VERSI SIMPLE: NAMA SAJA) */}
                <section id="booking" className="py-20 bg-white">
                    <div className="max-w-4xl mx-auto px-4">
                        <div className="bg-gray-50 border border-gray-200 rounded-2xl shadow-xl p-8">
                            <div className="text-center mb-8">
                                <h2 className="text-3xl font-bold text-gray-800">
                                    Formulir Pendaftaran
                                </h2>
                                <p className="text-gray-500">
                                    Silakan isi data diri Anda untuk mendapatkan
                                    nomor undian.
                                </p>
                            </div>

                            {successMsg && (
                                <div className="mb-6 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded font-bold text-center">
                                    {successMsg}
                                </div>
                            )}

                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {/* Pilihan Tanggal */}
                                    <div>
                                        <label className="block text-sm font-bold text-gray-700 mb-2">
                                            Pilih Tanggal
                                        </label>
                                        <input
                                            type="date"
                                            className="w-full border-gray-300 rounded-lg p-3"
                                            value={data.date}
                                            onChange={(e) =>
                                                setData("date", e.target.value)
                                            }
                                            required
                                        />
                                    </div>

                                    {/* Pilihan Sesi */}
                                    <div>
                                        <label className="block text-sm font-bold text-gray-700 mb-2">
                                            Pilih Sesi
                                        </label>
                                        <select
                                            className="w-full border-gray-300 rounded-lg p-3"
                                            value={data.session}
                                            onChange={(e) =>
                                                setData(
                                                    "session",
                                                    e.target.value
                                                )
                                            }
                                        >
                                            <option value="pagi">
                                                Pagi (08.00 - 12.00)
                                            </option>
                                            <option value="siang">
                                                Siang (13.00 - 17.00)
                                            </option>
                                            <option value="malam">
                                                Malam (19.00 - 23.00)
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {/* Input Nama (Hanya Ini Saja) */}
                                <div>
                                    <label className="block text-sm font-bold text-gray-700 mb-2">
                                        Nama Lengkap
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full border-gray-300 rounded-lg p-3"
                                        value={data.customer_name}
                                        onChange={(e) =>
                                            setData(
                                                "customer_name",
                                                e.target.value
                                            )
                                        }
                                        placeholder="Masukkan Nama Peserta"
                                        required
                                    />
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg"
                                >
                                    {processing
                                        ? "SEDANG MENDAFTAR..."
                                        : "DAFTAR SEKARANG"}
                                </button>
                            </form>
                        </div>
                    </div>
                </section>

                <footer className="bg-gray-900 text-white py-8 text-center">
                    <p>
                        &copy; 2025 Pemancingan EmpangMantap. All rights
                        reserved.
                    </p>
                    <div className="mt-2 text-gray-400 text-sm">
                        <a href="/login" className="hover:text-white">
                            Admin Login
                        </a>
                    </div>
                </footer>
            </div>
        </>
    );
}
