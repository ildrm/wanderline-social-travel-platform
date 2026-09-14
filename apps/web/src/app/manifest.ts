import type { MetadataRoute } from "next";

export default function manifest(): MetadataRoute.Manifest {
  return { name: "Wanderline", short_name: "Wanderline", description: "Travel coordination for journeys, experiences, and communities.", start_url: "/", display: "standalone", background_color: "#ffffff", theme_color: "#0c2340", lang: "en" };
}
