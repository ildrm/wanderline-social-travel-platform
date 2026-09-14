"use client";

export default function GlobalError({ reset }: { reset: () => void }) {
  return <main className="grid min-h-screen place-items-center px-6 text-center"><div className="max-w-md"><h1 className="font-display text-4xl">We lost the trail for a moment.</h1><p className="mt-4 text-slate-600">Your trip data is safe. Try loading this view again.</p><button type="button" onClick={reset} className="mt-8 min-h-12 rounded-lg bg-[#0c2340] px-6 font-semibold text-white">Try again</button></div></main>;
}
