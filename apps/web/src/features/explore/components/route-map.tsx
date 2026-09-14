import { en } from "@/i18n/en";

const stops = [
  { name: "Ankara", left: "78%", top: "72%" },
  { name: "London", left: "25%", top: "26%" },
  { name: "Paris", left: "30%", top: "40%" },
  { name: "Rome", left: "51%", top: "66%" },
  { name: "Madrid", left: "18%", top: "69%" },
];

export function RouteMap({ onShowList }: { onShowList?: () => void }) {
  return (
    <div className="relative min-h-[300px] overflow-hidden bg-[#e7f0f2]">
      <svg className="absolute inset-0 h-full w-full" viewBox="0 0 640 360" role="img" aria-label="Approximate route from Ankara to London, Paris, Rome, Madrid and back">
        <title>Approximate journey route</title>
        <path d="M60 40c65-32 130-11 168 10 45 26 98 10 136-9 50-25 125-19 206 18v211c-78 25-139 19-199 1-60-17-105 7-160 17-61 12-112-8-151-30Z" fill="#f4f7ec" stroke="#cbdcda" strokeWidth="2" />
        <path d="M500 260 160 93 192 144 116 248 326 238 500 260" fill="none" stroke="#f06452" strokeWidth="4" strokeDasharray="10 9" strokeLinecap="round" />
        <g fill="none" stroke="#b7cfcc" strokeWidth="1"><path d="M135 61c28 69 32 140 8 216M245 47c-9 62 4 140 36 230M362 45c-32 80-17 161 22 231M465 49c-13 63 6 130 41 197" /></g>
      </svg>
      {stops.map((stop, index) => (
        <div key={stop.name} className="absolute -translate-x-1/2 -translate-y-1/2" style={{ left: stop.left, top: stop.top }}>
          <span className={`block rounded-full border-[3px] border-white bg-[#f06452] shadow ${index === 0 ? "size-5" : "size-4"}`} />
          <span className="absolute left-1/2 top-6 -translate-x-1/2 whitespace-nowrap rounded bg-white/90 px-1.5 py-0.5 text-[11px] font-semibold text-[#0c2340]">{stop.name}</span>
        </div>
      ))}
      {onShowList && <button type="button" onClick={onShowList} className="absolute bottom-4 right-4 min-h-11 rounded-lg border border-[#cbd7df] bg-white px-4 text-sm font-semibold shadow-sm">{en.showList}</button>}
      <p className="absolute bottom-4 left-4 rounded bg-white/85 px-2 py-1 text-xs text-[#53647a]">Approximate locations</p>
    </div>
  );
}
