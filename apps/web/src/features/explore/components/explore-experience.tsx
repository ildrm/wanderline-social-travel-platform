"use client";

import Image from "next/image";
import Link from "next/link";
import { useMemo, useState } from "react";
import { Icon } from "@/components/icon";
import { en } from "@/i18n/en";
import type { Journey, JourneyMode } from "../types";
import { RouteMap } from "./route-map";

type Filter = JourneyMode | "accessible";

const money = (amountMinor: number, currency: string) =>
  new Intl.NumberFormat("en-GB", {
    style: "currency",
    currency,
    maximumFractionDigits: 0,
  }).format(amountMinor / 100);

function JourneyRow({ journey, selected, onSelect }: { journey: Journey; selected: boolean; onSelect: () => void }) {
  return (
    <button
      type="button"
      onClick={onSelect}
      className={`grid w-full gap-4 py-4 text-left transition sm:grid-cols-[210px_1fr_auto] ${selected ? "bg-[#fff8f6] ring-1 ring-inset ring-[#f06452]" : "hover:bg-[#f7f9fa]"}`}
    >
      <span className="relative mx-3 block aspect-[3/2] overflow-hidden rounded-lg sm:mx-0 sm:ml-3">
        <Image src={journey.cover} alt={journey.coverAlt} fill loading="eager" sizes="(max-width: 640px) 90vw, 210px" className="object-cover" />
      </span>
      <span className="px-3 sm:px-0">
        <span className="font-display text-lg font-bold sm:text-xl">{journey.title}</span>
        <span className="mt-1 block text-sm text-[#3f536b]">{journey.route.join(" · ")}</span>
        <span className="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-sm text-[#53647a]"><span>{journey.startDate}–{journey.endDate}</span><span>{journey.organizer}</span></span>
        <span className="mt-2 block text-sm text-[#718093]">{journey.mode[0].toUpperCase() + journey.mode.slice(1)} · {journey.tags.join(" · ")}</span>
      </span>
      <span className="flex items-center justify-between px-3 pb-1 sm:min-w-32 sm:justify-end sm:gap-5 sm:pr-5">
        <span className="text-right text-sm text-[#53647a]">{en.from} <strong className="block text-lg text-[#0c2340] sm:inline">{money(journey.amountMinor, journey.currency)}</strong><span className="block text-xs font-semibold text-[#d84b3b]">{journey.placesLeft} {en.placesLeft}</span></span>
        <Icon name="chevron" className="size-5" />
      </span>
    </button>
  );
}

function JourneyDetail({ journey, saved, onSave }: { journey: Journey; saved: boolean; onSave: () => void }) {
  const [shareStatus, setShareStatus] = useState<"idle" | "shared" | "failed">("idle");

  const share = async () => {
    const url = `${window.location.origin}/journeys/${journey.id}`;
    try {
      if (navigator.share) {
        await navigator.share({ title: journey.title, text: journey.description, url });
      } else {
        await navigator.clipboard.writeText(url);
      }
      setShareStatus("shared");
    } catch (error) {
      if (error instanceof DOMException && error.name === "AbortError") return;
      setShareStatus("failed");
    }
  };

  return (
    <div className="flex min-h-0 flex-1 flex-col overflow-y-auto p-5 lg:p-6">
      <div className="relative aspect-[16/6] shrink-0 overflow-hidden rounded-lg"><Image src={journey.cover} alt={journey.coverAlt} fill sizes="(max-width: 1024px) 100vw, 40vw" className="object-cover" priority /></div>
      <div className="mt-5 flex items-start justify-between gap-4">
        <div><h2 className="font-display text-2xl font-bold lg:text-[28px]">{journey.title}</h2><p className="mt-1 text-sm text-[#31465f]">{journey.route.join(" · ")}</p></div>
        <p className="shrink-0 text-right text-sm text-[#53647a]">{en.from} <strong className="block text-xl text-[#0c2340]">{money(journey.amountMinor, journey.currency)}</strong><span className="text-xs font-semibold text-[#d84b3b]">{journey.placesLeft} {en.placesLeft}</span></p>
      </div>
      <p className="mt-4 text-sm leading-6 text-[#40546c]">{journey.description}</p>
      <div className="mt-auto grid grid-cols-[1.4fr_1fr_1fr] gap-3 border-t border-[#d7e0e8] pt-5">
        <Link href={`/journeys/${journey.id}`} className="flex min-h-12 items-center justify-center gap-2 rounded-lg bg-[#f06452] px-3 text-sm font-bold text-white hover:bg-[#d84b3b]">{en.view}<Icon name="arrow" className="size-4" /></Link>
        <button type="button" aria-pressed={saved} onClick={onSave} className="flex min-h-12 items-center justify-center gap-2 rounded-lg border border-[#cbd5de] text-sm font-bold"><Icon name="bookmark" className={`size-4 ${saved ? "fill-current" : ""}`} />{saved ? en.saved : en.save}</button>
        <button type="button" onClick={() => void share()} className="flex min-h-12 items-center justify-center gap-2 rounded-lg border border-[#cbd5de] text-sm font-bold"><Icon name="share" className="size-4" />{shareStatus === "shared" ? "Copied" : shareStatus === "failed" ? "Try again" : en.share}</button>
      </div>
    </div>
  );
}

export function ExploreExperience({ initialJourneys }: { initialJourneys: Journey[] }) {
  const [activeFilters, setActiveFilters] = useState<Filter[]>([]);
  const [query, setQuery] = useState("");
  const [travelDate, setTravelDate] = useState("");
  const [style, setStyle] = useState<JourneyMode | "">("");
  const [sort, setSort] = useState<"relevant" | "price" | "soonest">("relevant");
  const [selectedId, setSelectedId] = useState(initialJourneys[0]?.id ?? "");
  const [savedIds, setSavedIds] = useState<string[]>([]);
  const [mobileMap, setMobileMap] = useState(false);
  const [navigationOpen, setNavigationOpen] = useState(false);

  const filtered = useMemo(() => {
    const normalized = query.trim().toLowerCase();
    const matching = initialJourneys.filter((journey) => {
      const haystack = [journey.title, journey.route.join(" "), journey.tags.join(" ")].join(" ").toLowerCase();
      const matchesQuery = !normalized || haystack.includes(normalized);
      const matchesFilters = activeFilters.every((filter) => filter === "accessible" ? journey.accessible : journey.mode === filter);
      const matchesStyle = !style || journey.mode === style;
      const matchesDate = !travelDate || journey.startDateIso >= travelDate;
      return matchesQuery && matchesFilters && matchesStyle && matchesDate;
    });
    if (sort === "price") return [...matching].sort((a, b) => a.amountMinor - b.amountMinor);
    if (sort === "soonest") return [...matching].sort((a, b) => a.startDateIso.localeCompare(b.startDateIso));
    return matching;
  }, [activeFilters, initialJourneys, query, sort, style, travelDate]);

  const selected = filtered.find((journey) => journey.id === selectedId) ?? filtered[0] ?? initialJourneys[0];
  const toggleFilter = (filter: Filter) => setActiveFilters((current) => current.includes(filter) ? current.filter((item) => item !== filter) : [...current, filter]);
  const toggleSaved = (id: string) => setSavedIds((current) => current.includes(id) ? current.filter((item) => item !== id) : [...current, id]);

  return (
    <div className="min-h-screen bg-white text-[#0c2340]">
      <header className="border-b border-[#d7e0e8] bg-white">
        <div className="mx-auto flex min-h-[72px] max-w-[1536px] items-center gap-8 px-5 sm:px-8 lg:px-12">
          <a href="#main" className="font-display text-2xl font-bold tracking-[-0.04em] sm:text-[28px]">{en.brand}</a>
          <nav aria-label="Primary navigation" className={`${navigationOpen ? "flex" : "hidden"} absolute inset-x-0 top-[72px] z-30 flex-col border-b border-[#d7e0e8] bg-white p-5 shadow-lg md:static md:flex md:flex-1 md:flex-row md:items-stretch md:border-0 md:p-0 md:shadow-none`}>
            <a href="#main" className="flex min-h-12 items-center px-4 text-sm font-semibold text-[#0c2340] md:border-b-2 md:border-[#f06452]">{en.nav.explore}</a>
            <a href="#journeys" className="flex min-h-12 items-center px-4 text-sm font-semibold text-[#53647a] hover:text-[#0c2340]">{en.nav.journeys}</a>
            {[en.nav.communities, en.nav.trips].map((item) => <span key={item} aria-disabled="true" className="flex min-h-12 cursor-not-allowed items-center px-4 text-sm font-semibold text-[#8b98a7]" title="Coming in a later platform milestone">{item}</span>)}
          </nav>
          <button type="button" aria-label={en.menu} aria-expanded={navigationOpen} onClick={() => setNavigationOpen((open) => !open)} className="ml-auto grid size-11 place-items-center rounded-lg border border-[#d7e0e8] md:hidden"><Icon name={navigationOpen ? "close" : "menu"} className="size-5" /></button>
          <Link href="/login" aria-label={en.account} className="hidden min-h-11 items-center rounded-lg border border-[#cbd5de] px-4 text-sm font-bold md:flex">Sign in</Link>
          <Link href="/journeys/new" className="hidden min-h-11 items-center rounded-lg bg-[#f06452] px-5 text-sm font-bold text-white transition hover:bg-[#d84b3b] sm:flex">{en.createJourney}</Link>
        </div>
      </header>

      <main id="main" className="mx-auto max-w-[1536px]">
        <section className="grid lg:grid-cols-[minmax(0,3fr)_minmax(390px,2fr)]">
          <div className="px-5 pb-12 pt-10 sm:px-8 lg:px-12 lg:pt-12">
            <h1 className="max-w-4xl font-display text-[clamp(2.25rem,4vw,4rem)] leading-[1.08] tracking-[-0.045em]">{en.headline}</h1>
            <form className="mt-7 grid overflow-hidden rounded-xl border border-[#bdcbd8] bg-white shadow-sm sm:grid-cols-[1fr_0.8fr_0.9fr_auto]" onSubmit={(event) => event.preventDefault()}>
              <label className="flex min-h-14 items-center gap-3 border-b border-[#d7e0e8] px-4 sm:border-b-0 sm:border-r"><Icon name="location" className="size-5 shrink-0" /><span className="sr-only">{en.search.where}</span><input value={query} onChange={(event) => setQuery(event.target.value)} placeholder={en.search.where} className="min-w-0 flex-1 border-0 bg-transparent text-[15px] outline-none placeholder:text-[#7b8998]" /></label>
              <label className="flex min-h-14 items-center gap-3 border-b border-[#d7e0e8] px-4 text-[15px] text-[#6a7889] sm:border-b-0 sm:border-r"><Icon name="calendar" className="size-5 shrink-0" /><span className="sr-only">{en.search.when}</span><input type="date" value={travelDate} min="2026-09-14" onChange={(event) => setTravelDate(event.target.value)} className="min-w-0 flex-1 bg-transparent outline-none" /></label>
              <label className="flex min-h-14 items-center gap-3 border-b border-[#d7e0e8] px-4 sm:border-b-0 sm:border-r"><Icon name="people" className="size-5" /><span className="sr-only">{en.search.style}</span><select className="w-full appearance-none bg-transparent text-[15px] text-[#6a7889] outline-none" value={style} onChange={(event) => setStyle(event.target.value as JourneyMode | "")}><option value="">{en.search.style}</option><option value="social">Social</option><option value="experience">Experience</option><option value="professional">Professional</option></select></label>
              <button type="submit" className="m-1.5 min-h-12 rounded-lg bg-[#f06452] px-8 font-bold text-white transition hover:bg-[#d84b3b]">{en.search.action}</button>
            </form>

            <div className="mt-5 flex flex-wrap items-center gap-2" aria-label="Journey filters">
              {([["social", en.filters.social], ["experience", en.filters.experience], ["professional", en.filters.professional], ["accessible", en.filters.accessible]] as [Filter, string][]).map(([filter, label]) => {
                const active = activeFilters.includes(filter);
                return <button key={filter} type="button" aria-pressed={active} onClick={() => toggleFilter(filter)} className={`min-h-10 rounded-full border px-4 text-sm font-semibold transition ${active ? "border-[#0c2340] bg-[#0c2340] text-white" : "border-[#cbd5de] bg-white text-[#31465f] hover:border-[#7f92a5]"}`}>{label}{active && <Icon name="close" className="ml-2 inline size-4" />}</button>;
              })}
              <div className="ml-auto hidden rounded-lg border border-[#cbd5de] p-1 sm:flex" role="group" aria-label="View mode"><button type="button" onClick={() => setMobileMap(false)} className="flex min-h-9 items-center gap-2 rounded-md bg-[#0c2340] px-3 text-sm font-semibold text-white"><Icon name="menu" className="size-4" />{en.list}</button><button type="button" onClick={() => setMobileMap(true)} className="flex min-h-9 items-center gap-2 px-3 text-sm font-semibold"><Icon name="map" className="size-4" />{en.map}</button></div>
            </div>

            <div id="journeys" className="mt-8 flex items-end justify-between gap-4"><div><h2 className="font-display text-2xl sm:text-[28px]">{en.journeysForYou}</h2><p aria-live="polite" className="mt-1 text-sm text-[#6a7889]">{filtered.length} {en.results}</p></div><select aria-label="Sort journeys" value={sort} onChange={(event) => setSort(event.target.value as typeof sort)} className="min-h-11 rounded-lg border border-[#cbd5de] bg-white px-3 text-sm"><option value="relevant">{en.sort}</option><option value="price">Price: low to high</option><option value="soonest">Soonest</option></select></div>
            <div className="mt-3 divide-y divide-[#e2e8ed] border-y border-[#e2e8ed]">{filtered.map((journey) => <JourneyRow key={journey.id} journey={journey} selected={selected?.id === journey.id} onSelect={() => setSelectedId(journey.id)} />)}</div>
            {filtered.length === 0 && <div className="py-16 text-center"><p className="font-display text-2xl">{en.unavailable}</p><button type="button" className="mt-5 min-h-11 rounded-lg border border-[#0c2340] px-5 font-semibold" onClick={() => { setActiveFilters([]); setQuery(""); setTravelDate(""); setStyle(""); }}>{en.clearFilters}</button></div>}
            <div className="mt-8 flex items-center justify-between"><h2 className="font-display text-2xl">{en.more}</h2><a href="#journeys" className="flex min-h-11 items-center gap-2 text-sm font-bold">{en.all}<Icon name="arrow" className="size-4" /></a></div>
          </div>

          <aside className={`${mobileMap ? "fixed inset-0 z-40 flex" : "hidden"} flex-col border-l border-[#d7e0e8] bg-white lg:sticky lg:top-0 lg:flex lg:h-[calc(100vh-72px)]`} aria-label="Selected journey and map">
            <button type="button" onClick={() => setMobileMap(false)} className="absolute right-4 top-4 z-50 grid size-11 place-items-center rounded-full bg-white shadow lg:hidden" aria-label="Close map"><Icon name="close" className="size-5" /></button>
            <RouteMap onShowList={() => setMobileMap(false)} />
            {selected && <JourneyDetail journey={selected} saved={savedIds.includes(selected.id)} onSave={() => toggleSaved(selected.id)} />}
          </aside>
        </section>
      </main>
      <button type="button" onClick={() => setMobileMap(true)} className="fixed bottom-5 left-1/2 z-20 flex min-h-12 -translate-x-1/2 items-center gap-2 rounded-full bg-[#0c2340] px-5 font-bold text-white shadow-xl lg:hidden"><Icon name="map" className="size-5" />{en.map}</button>
    </div>
  );
}
