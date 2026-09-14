import type { Metadata } from "next";
import Link from "next/link";
import { QuickCreateForm } from "@/features/journeys/components/quick-create-form";
import { en } from "@/i18n/en";

export const metadata: Metadata = { title: "Create a journey", robots: { index: false, follow: false } };

export default function NewJourneyPage() {
  return <main className="min-h-screen bg-[#f6f8f8] px-5 py-10 sm:py-14"><div className="mx-auto max-w-2xl"><Link href="/" className="font-display text-2xl font-bold tracking-[-0.04em]">{en.brand}</Link><section className="mt-8 rounded-2xl border border-[#d7e0e8] bg-white p-7 shadow-sm sm:p-10"><p className="text-sm font-bold uppercase tracking-[0.14em] text-[#d84b3b]">Quick Create</p><h1 className="mt-2 font-display text-4xl sm:text-5xl">Start with the essentials.</h1><p className="mb-8 mt-3 leading-7 text-[#53647a]">Create a private draft now. Dates, route, accessibility, and participation rules come next.</p><QuickCreateForm /></section></div></main>;
}
