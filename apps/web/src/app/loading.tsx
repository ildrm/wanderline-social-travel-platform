export default function Loading() {
  return <main className="mx-auto min-h-screen max-w-[1536px] px-6 py-10" aria-busy="true"><div className="h-10 w-48 animate-pulse rounded bg-slate-200" /><div className="mt-12 h-16 max-w-3xl animate-pulse rounded bg-slate-100" /><div className="mt-8 grid gap-8 lg:grid-cols-[minmax(0,3fr)_minmax(360px,2fr)]"><div className="h-[560px] animate-pulse rounded-2xl bg-slate-100" /><div className="h-[560px] animate-pulse rounded-2xl bg-slate-100" /></div><span className="sr-only">Loading journeys</span></main>;
}
