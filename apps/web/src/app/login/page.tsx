import type { Metadata } from "next";
import Link from "next/link";
import { AuthForm } from "@/features/auth/components/auth-form";
import { en } from "@/i18n/en";

export const metadata: Metadata = { title: "Sign in", robots: { index: false, follow: false } };

export default async function LoginPage({ searchParams }: { searchParams: Promise<{ returnTo?: string }> }) {
  const { returnTo } = await searchParams;
  return <main className="grid min-h-screen place-items-center bg-[#f6f8f8] px-5 py-12"><section className="w-full max-w-md rounded-2xl border border-[#d7e0e8] bg-white p-7 shadow-sm sm:p-9"><Link href="/" className="font-display text-2xl font-bold tracking-[-0.04em]">{en.brand}</Link><h1 className="mt-8 font-display text-4xl">Welcome back.</h1><p className="mt-3 leading-6 text-[#53647a]">Sign in to manage journeys, applications, and private trip details.</p><AuthForm mode="login" returnTo={returnTo} /></section></main>;
}
