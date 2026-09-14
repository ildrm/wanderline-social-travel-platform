import { ExploreExperience } from "@/features/explore/components/explore-experience";
import { journeys } from "@/features/explore/data/journeys";

export default function HomePage() {
  return <ExploreExperience initialJourneys={journeys} />;
}
