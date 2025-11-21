import React from "react";
import { Head, router, useForm } from "@inertiajs/react";

export default function Report({ bookings, selectedDate }) {
    // Fungsi ganti tanggal (Auto Refresh)
    const handleDateChange = (e) => {
        // GANTI route() JADI LINK MANUAL
        router.get(
            "/admin/reports",
            { date: e.target.value },
            { preserveState: true }
        );
    };

    return (
        <div className="min-h-screen bg-gray-100">
            <Head title="Laporan Harian" />

            {/* NAVBAR SIMPEL */}
            <nav className="bg-white shadow px-6 py-4 flex justify-between items-center sticky top-0 z-50">
                <div className="flex items-center space-x-4">
                    <h1 className="text-xl font-bold text-gray-800">
                        📋 Laporan Pendaftaran
                    </h1>
                    <span className="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                        Total: {bookings.length} Peserta
                    </span>
                </div>
                {/* GANTI route() JADI LINK MANUAL */}
                <a
                    href="/admin/dashboard"
                    className="text-gray-500 hover:text-gray-800"
                >
                    &larr; Kembali ke Dashboard
                </a>
            </nav>

            <div className="max-w-7xl mx-auto mt-8 px-4 pb-20">
                {/* FILTER TANGGAL */}
                <div className="bg-white p-6 rounded-lg shadow mb-6 flex flex-col md:flex-row items-center justify-between">
                    <div className="flex items-center space-x-4 mb-4 md:mb-0">
                        <label className="font-bold text-gray-700">
                            📅 Pilih Tanggal:
                        </label>
                        <input
                            type="date"
                            className="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            value={selectedDate}
                            onChange={handleDateChange}
                        />
                    </div>
                    <div className="text-sm text-gray-500 italic">
                        *Pilih tanggal untuk melihat pendaftar di hari tersebut.
                    </div>
                </div>

                {/* TABEL PESERTA */}
                <div className="bg-white shadow-lg rounded-lg overflow-hidden">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-800 text-white">
                            <tr>
                                <th className="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                    No. Urut
                                </th>
                                <th className="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">
                                    Nama Peserta
                                </th>
                                <th className="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                    Sesi
                                </th>
                                <th className="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                    Lapak (Kocokan)
                                </th>
                                <th className="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {bookings.length === 0 ? (
                                <tr>
                                    <td
                                        colSpan="5"
                                        className="px-6 py-12 text-center text-gray-400"
                                    >
                                        <div className="flex flex-col items-center">
                                            <svg
                                                className="w-12 h-12 mb-2"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                                />
                                            </svg>
                                            Belum ada pendaftar di tanggal ini.
                                        </div>
                                    </td>
                                </tr>
                            ) : (
                                bookings.map((booking) => (
                                    <RowBooking
                                        key={booking.id}
                                        booking={booking}
                                    />
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

// Komponen Baris
function RowBooking({ booking }) {
    const { data, setData, post, processing } = useForm({
        fishing_spot_id: booking.fishing_spot_id || "",
    });

    const handleSave = () => {
        if (!data.fishing_spot_id) return alert("Isi nomor lapak dulu!");
        // GANTI route() JADI LINK MANUAL DENGAN ID
        post(`/admin/reports/${booking.id}/update`);
    };

    return (
        <tr className="hover:bg-gray-50 transition">
            <td className="px-6 py-4 whitespace-nowrap text-center">
                <span className="bg-gray-100 text-gray-800 font-bold text-lg px-3 py-1 rounded-lg border border-gray-300">
                    #{booking.registration_number}
                </span>
            </td>
            <td className="px-6 py-4 whitespace-nowrap">
                <div className="text-sm font-bold text-gray-900">
                    {booking.customer_name}
                </div>
                {booking.customer_phone && (
                    <div className="text-xs text-gray-500">
                        {booking.customer_phone}
                    </div>
                )}
            </td>
            <td className="px-6 py-4 whitespace-nowrap text-center">
                <span
                    className={`px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase
                    ${
                        booking.session === "pagi"
                            ? "bg-green-100 text-green-800"
                            : booking.session === "siang"
                            ? "bg-yellow-100 text-yellow-800"
                            : "bg-indigo-100 text-indigo-800"
                    }`}
                >
                    {booking.session}
                </span>
            </td>
            <td className="px-6 py-4 whitespace-nowrap text-center">
                <div className="flex items-center justify-center space-x-2">
                    <span className="text-gray-500 font-bold">Lapak:</span>
                    <input
                        type="number"
                        min="1"
                        max="34"
                        className="w-16 text-center border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 font-bold"
                        value={data.fishing_spot_id}
                        onChange={(e) =>
                            setData("fishing_spot_id", e.target.value)
                        }
                        placeholder="-"
                    />
                </div>
            </td>
            <td className="px-6 py-4 whitespace-nowrap text-center">
                <button
                    onClick={handleSave}
                    disabled={processing}
                    className="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow text-sm font-bold transition"
                >
                    {processing ? "..." : "Simpan"}
                </button>
            </td>
        </tr>
    );
}
