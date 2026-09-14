import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  metadataBase: new URL(process.env.NEXT_PUBLIC_APP_URL ?? "http://localhost:3000"),
  title: { default: "Wanderline — Find your way. Meet your people.", template: "%s · Wanderline" },
  description: "Discover social journeys, guided experiences, and professional tours with privacy-aware planning.",
  openGraph: { title: "Wanderline", description: "Travel coordination for the journeys and people that move you.", type: "website" },
};

export default function RootLayout({ children }: LayoutProps<"/">) {
  return <html lang="en"><body>{children}</body></html>;
}
