import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { Icon } from "@/components/icon";
import { journeys } from "@/features/explore/data/journeys";
import { en } from "@/i18n/en";

type PageProps = { params: Promise<{ slug: string }> };

const money = (amountMinor: number, currency: string) =>
  new Intl.NumberFormat("en-GB", {
    style: "currency",
    currency,
    maximumFractionDigits: 0,
  }).format(amountMinor / 100);

export function generateStaticParams() {
  return journeys.map((journey) => ({ slug: journey.id }));
}

export async function generateMetadata({ params }: PageProps): Promise<Metadata> {
  const { slug } = await params;
  const journey = journeys.find((candidate) => candidate.id === slug);
  if (!journey) return {};

  return {
    title: journey.title,
    description: journey.description,
    alternates: { canonical: `/journeys/${journey.id}` },
    openGraph: {
      title: journey.title,
      description: journey.description,
      images: [{ url: journey.cover, alt: journey.coverAlt }],
    },
    twitter: {
      card: "summary_large_image",
      title: journey.title,
      description: journey.description,
      images: [journey.cover],
    },
  };
}

export default async function JourneyPage({ params }: PageProps) {
  const { slug } = await params;
  const journey = journeys.find((candidate) => candidate.id === slug);
  if (!journey) notFound();

  const structuredData = {
    "@context": "https://schema.org",
    "@type": "TouristTrip",
    name: journey.title,
    description: journey.description,
    image: journey.cover,
    touristType: journey.mode,
    itinerary: {
      "@type": "ItemList",
      itemListElement: journey.route.map((name, index) => ({ "@type": "ListItem", position: index + 1, name })),
    },
    offers: {
      "@type": "Offer",
      price: journey.amountMinor / 100,
      priceCurrency: journey.currency,
      availability: "https://schema.org/InStock",
    },
  };

  return (
    <main className="min-h-screen bg-[#f6f8f8] text-[#0c2340]">
      <script type="application/ld+json" dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData).replaceAll("<", "\\u003c") }} />
      <header className="border-b border-[#d7e0e8] bg-white">
        <div className="mx-auto flex min-h-[72px] max-w-6xl items-center justify-between px-5 sm:px-8">
          <Link href="/" className="font-display text-2xl font-bold tracking-[-0.04em]">{en.brand}</Link>
          <Link href="/" className="flex min-h-11 items-center gap-2 rounded-lg border border-[#cbd5de] px-4 text-sm font-bold"><Icon name="chevron" className="size-4 rotate-180" />Back to explore</Link>
        </div>
      </header>

      <article className="mx-auto max-w-6xl px-5 py-8 sm:px-8 sm:py-12">
        <div className="relative aspect-[16/8] overflow-hidden rounded-2xl bg-[#dfeee9] sm:aspect-[16/7]">
          <Image src={journey.cover} alt={journey.coverAlt} fill priority sizes="(max-width: 1200px) 100vw, 1152px" className="object-cover" />
        </div>
        <div className="mt-8 grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">
          <div>
            <p className="text-sm font-bold uppercase tracking-[0.15em] text-[#d84b3b]">{journey.mode} journey</p>
            <h1 className="mt-2 font-display text-4xl leading-tight sm:text-5xl">{journey.title}</h1>
            <p className="mt-3 text-lg text-[#40546c]">{journey.route.join(" · ")}</p>
            <p className="mt-6 max-w-3xl text-base leading-7 text-[#40546c]">{journey.description}</p>

            <section aria-labelledby="route-heading" className="mt-10">
              <h2 id="route-heading" className="font-display text-3xl">The route</h2>
              <ol className="mt-5 grid gap-3 sm:grid-cols-2">
                {journey.route.map((stop, index) => (
                  <li key={stop} className="flex min-h-20 items-center gap-4 rounded-xl border border-[#d7e0e8] bg-white p-4">
                    <span className="grid size-10 shrink-0 place-items-center rounded-full bg-[#dfeee9] font-bold">{index + 1}</span>
                    <span><strong className="block">{stop}</strong><span className="text-sm text-[#66778b]">Planned stop · Local time</span></span>
                  </li>
                ))}
              </ol>
            </section>
          </div>

          <aside className="h-fit rounded-2xl border border-[#d7e0e8] bg-white p-6 shadow-sm lg:sticky lg:top-6" aria-label="Journey booking summary">
            <p className="text-sm text-[#53647a]">{journey.startDate}–{journey.endDate}</p>
            <p className="mt-2 text-sm text-[#53647a]">Hosted by <strong className="text-[#0c2340]">{journey.organizer}</strong></p>
            <p className="mt-6 text-sm text-[#53647a]">From <strong className="block font-display text-3xl text-[#0c2340]">{money(journey.amountMinor, journey.currency)}</strong></p>
            <p className="mt-1 text-sm font-semibold text-[#d84b3b]">{journey.placesLeft} places left</p>
            <Link href={`/register?returnTo=/journeys/${journey.id}`} className="mt-6 flex min-h-12 items-center justify-center rounded-lg bg-[#f06452] px-5 font-bold text-white hover:bg-[#d84b3b]">Join this journey</Link>
            <p className="mt-3 text-center text-xs leading-5 text-[#66778b]">Your exact location and private profile details are never shown publicly.</p>
          </aside>
        </div>
      </article>
    </main>
  );
}
