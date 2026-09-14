import type { ReactNode, SVGProps } from "react";

type IconName = "arrow" | "calendar" | "chevron" | "close" | "location" | "map" | "menu" | "people" | "share" | "bookmark";
const paths: Record<IconName, ReactNode> = {
  arrow: <path d="M5 12h14m-5-5 5 5-5 5" />,
  calendar: <><path d="M6 3v3m12-3v3M4 9h16" /><rect x="4" y="5" width="16" height="16" rx="2" /></>,
  chevron: <path d="m9 6 6 6-6 6" />,
  close: <path d="m7 7 10 10M17 7 7 17" />,
  location: <><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="2.5" /></>,
  map: <path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3V6Zm6-3v15m6-12v15" />,
  menu: <path d="M4 7h16M4 12h16M4 17h16" />,
  people: <><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" /><circle cx="9.5" cy="7" r="4" /><path d="M19 8v6m3-3h-6" /></>,
  share: <><circle cx="18" cy="5" r="2" /><circle cx="6" cy="12" r="2" /><circle cx="18" cy="19" r="2" /><path d="m8 11 8-5m-8 7 8 5" /></>,
  bookmark: <path d="M6 4h12v17l-6-4-6 4V4Z" />,
};

export function Icon({ name, ...props }: SVGProps<SVGSVGElement> & { name: IconName }) {
  return <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true" {...props}>{paths[name]}</svg>;
}
