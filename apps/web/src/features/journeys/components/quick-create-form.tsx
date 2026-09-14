"use client";

import Link from "next/link";
import { FormEvent, useState } from "react";
import { apiRequest, initializeCsrf, type ApiProblem } from "@/lib/api";

type CreatedJourney = { data: { id: string; title: string; status: string; visibility: string } };

export function QuickCreateForm() {
  const [pending, setPending] = useState(false);
  const [error, setError] = useState("");
  const [created, setCreated] = useState<CreatedJourney["data"]>();
  const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || "UTC";

  const submit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    setPending(true);
    setError("");
    const values = Object.fromEntries(new FormData(event.currentTarget).entries());
    try {
      await initializeCsrf();
      const response = await apiRequest<CreatedJourney>("/api/v1/journeys", {
        method: "POST",
        body: JSON.stringify({ ...values, capacity: Number(values.capacity), timezone }),
      });
      setCreated(response.data);
    } catch (caught) {
      const requestError = caught as Error & { status?: number; problem?: ApiProblem };
      if (requestError.status === 401) {
        setError("Sign in before creating a journey.");
      } else {
        setError(requestError.message);
      }
    } finally {
      setPending(false);
    }
  };

  if (created) {
    return <section aria-live="polite" className="rounded-2xl border border-[#b9d8cf] bg-[#f0f8f5] p-7"><p className="text-sm font-bold uppercase tracking-[0.14em] text-[#2c6657]">Draft created</p><h2 className="mt-2 font-display text-3xl">{created.title}</h2><p className="mt-3 text-[#40546c]">Status: {created.status.toLowerCase()} · Visibility: {created.visibility.toLowerCase()}</p><p className="mt-2 break-all text-xs text-[#66778b]">Journey ID: {created.id}</p><Link href="/" className="mt-6 inline-flex min-h-11 items-center rounded-lg border border-[#0c2340] px-5 font-bold">Return to Explore</Link></section>;
  }

  return (
    <form onSubmit={(event) => void submit(event)} className="space-y-5">
      <label className="block text-sm font-semibold">Journey title<input name="title" required minLength={3} maxLength={160} placeholder="A weekend in Cappadocia" className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 font-normal outline-none focus:border-[#0c2340]" /></label>
      <label className="block text-sm font-semibold">Journey mode<select name="mode" defaultValue="SOCIAL" className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] bg-white px-4 font-normal outline-none focus:border-[#0c2340]"><option value="SOCIAL">Social</option><option value="EXPERIENCE">Experience</option><option value="PROFESSIONAL">Professional</option><option value="PRIVATE_GROUP">Private group</option></select></label>
      <div className="grid gap-5 sm:grid-cols-2">
        <label className="block text-sm font-semibold">Capacity<input name="capacity" type="number" min={1} max={100000} defaultValue={8} required className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 font-normal outline-none focus:border-[#0c2340]" /></label>
        <label className="block text-sm font-semibold">Visibility<select name="visibility" defaultValue="PRIVATE" className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] bg-white px-4 font-normal outline-none focus:border-[#0c2340]"><option value="PRIVATE">Private</option><option value="UNLISTED">Unlisted</option><option value="PUBLIC">Public</option></select></label>
      </div>
      <p className="rounded-lg bg-[#eef4f5] p-3 text-sm leading-6 text-[#40546c]">New journeys start as drafts. Publishing requires a separate lifecycle transition, so an accidental click cannot expose an incomplete plan.</p>
      {error && <div role="alert" className="rounded-lg bg-[#fff0ed] p-3 text-sm text-[#962d24]">{error}{error.startsWith("Sign in") && <Link href="/login?returnTo=/journeys/new" className="ml-1 font-bold underline">Sign in</Link>}</div>}
      <button type="submit" disabled={pending} className="min-h-12 w-full rounded-lg bg-[#f06452] px-5 font-bold text-white hover:bg-[#d84b3b] disabled:cursor-wait disabled:opacity-60">{pending ? "Creating draft…" : "Create private draft"}</button>
    </form>
  );
}
