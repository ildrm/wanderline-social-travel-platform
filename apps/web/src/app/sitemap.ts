import type { MetadataRoute } from "next";
import { journeys } from "@/features/explore/data/journeys";

export default function sitemap(): MetadataRoute.Sitemap {
  const origin = process.env.NEXT_PUBLIC_APP_URL ?? "http://localhost:3000";
  return [
    { url: origin, changeFrequency: "daily", priority: 1 },
    ...journeys.map((journey) => ({ url: `${origin}/journeys/${journey.id}`, changeFrequency: "weekly" as const, priority: 0.8 })),
  ];
}
